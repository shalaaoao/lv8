<?php

namespace App\Console\Commands\Design2B\Factory;

// 普通2B青年的短信发送
class SendMessage
{
    const TYPE_ALI     = 1; // 阿里云
    const TYPE_BAIDU   = 2; // 百度云
    const TYPE_JIGUANG = 3; // 极光

    public static function send(int $type, string $phone, string $msg)
    {
        switch ($type) {
            case self::TYPE_ALI:

                // 对接阿里云，各种配置加载...
                $appId     = config('app.appId');
                $appSecret = config('app.appSecret');

                // 加密方法-按规则生成秘钥
                $key = md5($phone . '-' . $msg . '-' . $appSecret);

                // curl

                break;

            case self::TYPE_BAIDU:

                // 同上，对接百度云
            case self::TYPE_JIGUANG:

                // 同上，对接极光

            default:
                return null;
        }
    }

    // 这么写似乎也没什么大问题啊...
















    // 要把三家的配置加载重新写一遍，感觉有点离谱了啊。那如果还有20个这样的方法呢？
    public static function appPush($type, int $userId, string $msg, array $images, string $url)
    {
        switch ($type) {
            case self::TYPE_ALI:

                // 对接阿里云，各种配置加载...
                $appId     = config('app.appId');
                $appSecret = config('app.appSecret');

                // 加密方法-按规则生成秘钥
                $key = md5($userId . '-' . $msg . '-' . $appSecret);

                // curl
                break;

            case self::TYPE_BAIDU:

                // 同上，对接百度云
            case self::TYPE_JIGUANG:

                // 同上，对接极光

            default:
                return null;
        }
    }
}
