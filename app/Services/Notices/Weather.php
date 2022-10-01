<?php

namespace App\Services\Notices;

use App\Utils\CurlUtil;
use Illuminate\Support\Facades\Cache;

class Weather
{
    const WID = [
        0  => '晴',
        1  => '多云',
        2  => '阴',
        3  => '阵雨',
        4  => '雷阵雨',
        5  => '雷阵雨伴有冰雹',
        6  => '雨夹雪',
        7  => '小雨',
        8  => '中雨',
        9  => '大雨',
        10 => '暴雨',
        11 => '大暴雨',
        12 => '特大暴雨',
        13 => '阵雪',
        14 => '小雪',
        15 => '中雪',
        16 => '大雪',
        17 => '暴雪',
        18 => '雾',
        19 => '冻雨',
        20 => '沙尘暴',
        21 => '小到中雨',
        22 => '中到大雨',
        23 => '大到暴雨',
        24 => '暴雨到大暴雨',
        25 => '大暴雨到特大暴雨',
        26 => '小到中雪',
        27 => '中到大雪',
        28 => '大到暴雪',
        29 => '浮尘',
        30 => '扬沙',
        31 => '强沙尘暴',
        53 => '霾',
    ];

    public $weather;
    private static  $ins;

    public function __construct()
    {
        $this->weather = Cache::remember('REAL_TIME_WEATHER', 10, function () {
            $url = "http://apis.juhe.cn/simpleWeather/query?city=上海&key=fbf1128230e1257a067be8037bfca591";
            $res = (string)CurlUtil::get_data_from_url($url);

            $arr = json_decode($res, true);

            if (!isset($arr) || $arr['error_code'] != 0) {
                return [];
            }

            return $arr['result'] ?? [];
        });
    }

    public static function instance()
    {
        if (self::$ins) {
            return self::$ins;
        }

        return new static();
    }


    public function eat()
    {
        // 实时
        $realtime    = $this->weather['realtime'];
        $aqi         = $realtime['aqi'] ?? 0; // 空气指数
        $temperature = $realtime['temperature'] ?? null; // 温度
        $wid         = (int)($this->weather['wid'] ?? 0); // 气候

        $msg = '';
        if ($temperature <= 0 || $temperature >= 30) {
            $msg .= "当前气温:{$temperature}°C" . PHP_EOL;
        }

        if ($aqi >= 200) {
            $msg .= "当前雾霾指数:{$aqi}" . PHP_EOL;
        }

        if ($wid >= 3) {
            $msg .= "当前{$wid}" . PHP_EOL;
        }

        if ($msg) {
            $msg .= '建议提前点外卖哦';
        }

        return $msg;
    }

    public function warn()
    {
        $msg = '';
        $h   = (int)date('H');
        if ($h >= 16) {

            // 看明天
            $k   = 1;
            $msg .= '明日' . $this->weather['future'][$k]['date'] . ',';
        } else {

            // 看今天
            $k   = 0;
            $msg .= '今日' . $this->weather['future'][$k]['date'] . ',';
        }
        $wea      = $this->weather['future'][$k] ?? [];
        $tem_arr  = explode('/', $wea['temperature'] ?? '');
        $low_tem  = $tem_arr[0] ?? 3;
        $high_tem = $tem_arr[1] ?? 29;

        $msg .= "气温{$low_tem} - {$high_tem}";

        if ($low_tem < 3) {
            $msg .= "，🐷小饱饱要注意保暖哦" . PHP_EOL;
        }

        if ($high_tem > 30) {
            $msg .= "，🐷小饱饱要注意散热哦" . PHP_EOL;
        }

        $wid_day   = $wid_day['day'] ?? 0;
        $wid_night = $wid_day['night'] ?? 0;
        if ($wid_day >= 3) {
            $msg .= "白天存在{$wid_day}天气，要注意哦" . PHP_EOL;
        }

        if ($wid_night) {
            $msg .= "夜间存在{$wid_day}天气，要注意哦" . PHP_EOL;
        }

        return $msg;
    }

}
