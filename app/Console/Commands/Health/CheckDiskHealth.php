<?php

namespace App\Console\Commands\Health;

use App\Services\Notices\BaseNotice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckDiskHealth extends Command
{
    protected $signature = 'disk:check-health {--device= : 可选，指定单个硬盘设备（如/dev/sda）}';
    protected $description = '检测硬盘健康并将结果存入变量，用于推送机器人';

    // 新增：存储所有输出内容的变量
    private $outputContent = '';

    public function handle()
    {
        // 初始化输出内容（标题）
        $this->appendOutput('=== 硬盘健康检测报告 ===' . PHP_EOL);

        // 1. 获取要检测的硬盘设备
        $devices = $this->option('device') ? [$this->option('device')] : $this->getAllDiskDevices();

        if (empty($devices)) {
            $this->appendOutput('❌ 未检测到任何硬盘设备，请确认系统权限或硬件连接' . PHP_EOL);
            $this->pushToRobot($this->outputContent); // 推送空结果
            return Command::FAILURE;
        }

        // 2. 逐个检测并收集结果
        foreach ($devices as $device) {
            $this->appendOutput(PHP_EOL . "【检测设备：{$device}】" . PHP_EOL);
            $this->appendOutput(str_repeat('-', 50) . PHP_EOL);

            if (!file_exists($device)) {
                $this->appendOutput("❌ 设备 {$device} 不存在，请检查设备名" . PHP_EOL);
                continue;
            }

            // 获取SMART数据
            $smartData = $this->getSmartData($device);
            if (empty($smartData)) {
                $this->appendOutput("❌ 获取 {$device} SMART数据失败（需安装smartctl并配置sudo免密）" . PHP_EOL);
                continue;
            }

            // 解析并追加结果
            $this->parseAndAppendSmartData($smartData);
        }

        // 3. 追加报告结尾
        $this->appendOutput(PHP_EOL . '=== 检测完成 ===' . PHP_EOL);
        $this->appendOutput("检测时间：" . date('Y-m-d H:i:s') . PHP_EOL);

        // 4. 关键：推送变量到机器人（这里调用你的机器人推送逻辑）
        $this->pushToRobot($this->outputContent);

        // 可选：同时输出到控制台（方便调试）
        $this->line($this->outputContent);

        BaseNotice::fsSend($this->outputContent);

        return Command::SUCCESS;
    }

    /**
     * 核心调整：将内容追加到输出变量（替代原控制台输出）
     */
    private function appendOutput(string $content): void
    {
        $this->outputContent .= $content;
    }

    /**
     * 推送机器人的示例方法（需你根据实际机器人接口修改）
     */
    private function pushToRobot(string $content): void
    {
        // 示例：对接钉钉机器人（替换为你的机器人Webhook和密钥）
        $webhook = 'https://oapi.dingtalk.com/robot/send?access_token=你的机器人token';
        $data = [
            'msgtype' => 'text',
            'text' => ['content' => $content]
        ];

        // 发起请求（可用Guzzle或Laravel的Http客户端）
        try {
            \Illuminate\Support\Facades\Http::post($webhook, $data);
            Log::info('硬盘检测结果已推送机器人');
        } catch (\Exception $e) {
            Log::error('机器人推送失败', ['error' => $e->getMessage()]);
        }
    }

    // 以下方法逻辑不变，仅输出部分改为调用appendOutput
    protected function getAllDiskDevices(): array
    {
        $devices = [];
        exec('lsblk -d -n -o NAME', $output, $returnVar);
        if ($returnVar !== 0) return $devices;

        foreach ($output as $name) {
            $name = trim($name);
            if (str_starts_with($name, 'sd') || str_starts_with($name, 'nvme')) {
                $devices[] = "/dev/{$name}";
            }
        }
        return $devices;
    }

    protected function getSmartData(string $device): string
    {
        exec("sudo smartctl -a {$device}", $output, $returnVar);
        Log::info('smartctl执行结果', ['device' => $device, 'return_var' => $returnVar]);
        return $returnVar === 0 ? implode(PHP_EOL, $output) : '';
    }

    protected function parseAndAppendSmartData(string $smartData): void
    {
        $lines = explode(PHP_EOL, $smartData);
        $isNvme = str_contains($smartData, 'NVMe Version');

        // 1. 基础信息
        $model = $this->extractValue($lines, 'Device Model:');
        $capacity = $this->extractValue($lines, 'User Capacity:', 'Total NVM Capacity:');
        $this->appendOutput("1. 基础信息" . PHP_EOL);
        $this->appendOutput("   型号：{$model}" . PHP_EOL);
        $this->appendOutput("   容量：{$capacity}" . PHP_EOL . PHP_EOL);

        // 2. 核心健康状态
        $smartResult = $this->extractValue($lines, 'SMART overall-health self-assessment test result:');
        $this->appendOutput("2. 核心健康状态" . PHP_EOL);
        $status = $smartResult === 'PASSED' ? "✅ SMART检测：{$smartResult}" : "❌ SMART检测：{$smartResult}（需立即备份）";
        $this->appendOutput("   {$status}" . PHP_EOL . PHP_EOL);

        // 3. 寿命与备用容量
        $this->appendOutput("3. 寿命与备用容量" . PHP_EOL);
        if ($isNvme) {
            $usedPercent = $this->extractValue($lines, 'Percentage Used:');
            $spare = $this->extractValue($lines, 'Available Spare:');
            $this->appendOutput("   寿命消耗：{$usedPercent}（越低越好）" . PHP_EOL);
            $this->appendOutput("   备用容量：{$spare}（100%为优）" . PHP_EOL);
        } else {
            $wearLevel = $this->extractValue($lines, 'Wear_Leveling_Count', 'RAW_VALUE');
            $reallocSector = $this->extractValue($lines, 'Reallocated_Sector_Ct', 'RAW_VALUE');
            $this->appendOutput("   磨损计数：{$wearLevel}（初始100）" . PHP_EOL);
            $this->appendOutput("   重映射扇区：{$reallocSector}（0为优）" . PHP_EOL);
        }
        $this->appendOutput(PHP_EOL);

        // 4. 温度与使用强度
        $temp = $this->extractValue($lines, 'Temperature:', 'Temperature Sensor 1:');
        $powerOnHours = $this->extractValue($lines, 'Power On Hours:');
        $this->appendOutput("4. 温度与使用强度" . PHP_EOL);
        $this->appendOutput("   当前温度：{$temp}（<50℃为优）" . PHP_EOL);
        $this->appendOutput("   通电时间：{$powerOnHours}小时" . PHP_EOL . PHP_EOL);

        // 5. 异常指标
        $integrityErrors = $this->extractValue($lines, 'Media and Data Integrity Errors:');
        $errorLogs = $this->extractValue($lines, 'Error Information Log Entries:');
        $unsafeShutdown = $this->extractValue($lines, 'Unsafe Shutdowns:');
        $this->appendOutput("5. 异常指标" . PHP_EOL);
        $this->appendOutput("   介质完整性错误：" . ($integrityErrors ?: '0') . PHP_EOL);
        $this->appendOutput("   错误日志条目：" . ($errorLogs ?: '0') . PHP_EOL);
        $this->appendOutput("   不安全关机：{$unsafeShutdown}次" . PHP_EOL);
    }

    protected function extractValue(array $lines, string ...$keywords): string
    {
        foreach ($keywords as $keyword) {
            foreach ($lines as $line) {
                if (str_contains($line, $keyword)) {
                    return trim(str_replace($keyword, '', $line)) ?: '未获取';
                }
            }
        }
        return '未获取';
    }
}
