<?php

namespace App\Console\Commands\Pt;

use App\Model\Pt\PtCrawlerLogModel;
use App\Model\Pt\PtCrawlerModel;
use App\Model\Pt\PtTokenModel;
use App\Services\Notices\BaseNotice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MTeamCrawlerCommand extends Command
{
    protected $signature = 'pt:m-team-crawler';

    protected $description = 'pt-馒头爬虫';

    /**
     * 服务端视频的信息
     * @var array
     */
    private array $video;

    /**
     * 匹配到的结果
     * @var array
     */
    private array $matchResult;

    private PtCrawlerLogModel $ptCrawlerLogModel;

    public function handle()
    {
        Log::info("pt m-team-crawler start...");

        // 1. 查库
        PtCrawlerModel::query()->where('status', PtCrawlerModel::STATUS_ING)->get()->each(function ($item) {

            $this->matchResult = [];

            // 2. curl
            $data = $this->curl($item->id, $item->mode, $item->keyword, $item->discount);
            if (!isset($data['code']) || $data['code'] != '0') {

                // 记录日志，抛异常
                BaseNotice::fsSend("请求pt失败：" . json_encode($data, JSON_UNESCAPED_UNICODE));

                return;
            }

            foreach ($data['data']['data'] ?? [] as $val) {

                $this->video = $val;

                // 3. 匹配规则
                $match = $this->matchRule($item->ruleArr);
                if ($match) {
                    $this->matchResult[] = $match;
                }
            }

            // 4. 命中发送飞书
            if ($this->matchResult) {

                BaseNotice::fsSend(implode('', $this->matchResult));

                $this->info(implode('', $this->matchResult));

                // 更新状态
                $item->status = PtCrawlerModel::STATUS_DONE;
                $item->save();

                // 更新请求的命中结果
                $this->ptCrawlerLogModel->match_result = implode('', $this->matchResult);
                $this->ptCrawlerLogModel->save();
            }
        });
    }

    /**
     * 规则匹配
     * @param array $rule
     * @return string
     */
    private function matchRule(array $rule): string
    {
        // 没有规则，直接匹配上
        if (!$rule) {
            return $this->formatMatchResult();
        }

        foreach ($rule as $key => $value) {
            if (strpos($this->video[$key], $value) !== false) {
                return $this->formatMatchResult();
            }
        }

        return '';
    }

    /**
     * 格式化匹配结果
     * @return string
     */
    private function formatMatchResult(): string
    {
//        return [
//            'name'        => $this->video['name'] ?? '',
//            'smallDescr'  => $this->video['smallDescr'] ?? '',
//            'createdDate' => $this->video['createdDate'] ?? '',
//        ];

        $str = "名称：" . $this->video['name'] . PHP_EOL;
        $str .= "简介：" . $this->video['smallDescr'] . PHP_EOL;
        $str .= "日期：" . $this->video['createdDate'] . PHP_EOL;
        $str .= "https://xp.m-team.io/detail/" . $this->video['id'] . PHP_EOL;

        $str .= PHP_EOL;

        return $str;
    }

    private function curl(int $id, string $mode, string $keyword, string $discount)
    {
        $url = 'https://api.m-team.io/api/torrent/search';

        $token = PtTokenModel::getToken('pt');

        $headers = [
            'accept:application/json, text/plain, */*',
            'accept-language: zh-CN,zh;q=0.9,zh-TW;q=0.8',
            'cache-control: no-cache',
            'content-type: application/json',
            'authorization: ' . $token,
            'origin:https://kp.m-team.cc',
            'priority:u=1, i',
            'referer:https://kp.m-team.cc/',
            'sec-ch-ua:"Not/A)Brand";v="8", "Chromium";v="126", "Google Chrome";v="126"',
            'ts:'.time(),
            'user-agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
            'visitorid:d1f0856ff054685012fd41e679a84d7e',
            'webversion:1010',
        ];

        $data = [
            'mode'       => $mode,
            'categories' => [],
            'visible'    => 1,
            'keyword'    => $keyword,
            'pageNumber' => 1,
            'pageSize'   => 10
        ];

        if ($discount) {
            $data['discount'] = $discount;
        }

        // 记录日志
        $this->ptCrawlerLogModel = PtCrawlerLogModel::query()->create(['pt_crawler_id' => $id, 'request' => json_encode($data, JSON_UNESCAPED_UNICODE)]);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if ($response === false) {
            die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        }

//        echo 'Response HTTP Status Code : ' . curl_getinfo($ch, CURLINFO_HTTP_CODE);
//        echo '\nResponse HTTP Body : ' . $response;

        curl_close($ch);

        Log::info("pt result: {$response}");

        return json_decode($response, true);
    }
}
