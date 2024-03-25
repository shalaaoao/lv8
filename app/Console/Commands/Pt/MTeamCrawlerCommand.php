<?php

namespace App\Console\Commands\Pt;

use App\Model\Pt\PtCrawlerModel;
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
    private array $matchResult = [];

    public function handle()
    {
        Log::info("pt m-team-crawler start...");

        // 1. 查库
        PtCrawlerModel::query()->where('status', PtCrawlerModel::STATUS_ING)->get()->each(function ($item) {

            // 2. curl
            $data = $this->curl($item->mode, $item->keyword, $item->discount);
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

    private function curl(string $mode, string $keyword, string $discount)
    {
        $url = 'https://xp.m-team.io/api/torrent/search';

        $headers = [
            'authority: xp.m-team.io',
            'accept: application/json, text/plain, */*',
            'accept-language: zh-CN,zh;q=0.9,zh-TW;q=0.8',
            'cache-control: no-cache',
            'content-type: application/json',
            'cookie: tp=N2M0Y2M1OWI4NDVhYWRjMDNkODQ3ZThlMmMyN2Y2YWY1NDJhYWNhNA%3D%3D; auth=eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJzaGFsYWFvYW8iLCJ1aWQiOjMxMTU0NCwianRpIjoiODU3NTQ2MzgtZTIzMC00MmRiLTg1ZTQtNGVlNzYyZWNlYzEyIiwiaXNzIjoiaHR0cHM6Ly94cC5tLXRlYW0uaW8iLCJpYXQiOjE3MTEzMjkwOTcsImV4cCI6MTcxMTkzMzg5N30.pqRp6HAN8rup1-x4KThaa3pbjKDbSTVZUPiT5VECYuQglqR_i6LjdpEm_bCEEqpPEpKOQlOFQF4pliB3pZpfyw',
            'origin: https://xp.m-team.io',
            'pragma: no-cache',
            'referer: https://xp.m-team.io/browse/tvshow?keyword=Simple%20Days',
            'sec-ch-ua: "Chromium";v="122", "Not(A:Brand";v="24", "Google Chrome";v="122"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "macOS"',
            'sec-fetch-dest: empty',
            'sec-fetch-mode: cors',
            'sec-fetch-site: same-origin',
            'ts: X',
            'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'
        ];

        $data = json_encode([
            'mode'       => $mode,
            'categories' => [],
            'visible'    => 1,
            'keyword'    => $keyword,
            'pageNumber' => 1,
            'pageSize'   => 100
        ]);

        if ($discount) {
            $data['discount'] = $discount;
        }

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

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
