<?php

namespace App\Services\Notices;

use Guanguans\Notify\Factory;

class BaseNotice
{
    public static function send(string $content, array $atMobiles = [])
    {
        Factory::dingTalk()
               ->setToken('745532d0616221f2e3520b1f7c2ac89a308f51f9bc13936ef68e831a4e1c1fa6')
               ->setSecret('')
               ->setMessage((new \Guanguans\Notify\Messages\DingTalk\TextMessage([
                   'content'   => "『aoao』".$content,
                   'atMobiles' => $atMobiles,
                   // 'atDingtalkIds' => [123456],
                   // 'isAtAll'   => false,
               ])))
               ->send();
    }
}
