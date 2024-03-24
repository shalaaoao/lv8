<?php

namespace App\Services\Notices;

use Guanguans\Notify\Factory;

class BaseNotice
{
    public static function dingSend(string $content, array $atMobiles = [])
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

    public static function fsSend(string $content)
    {
        Factory::feiShu()
                    ->setToken('fefc8f74-0384-4c34-a7bb-2061e10563ed')
                    ->setSecret('qF4XrVgQ1631VYaUPRRtEh')
                    ->setMessage((new \Guanguans\Notify\Messages\feishu\TextMessage($content)))
                    ->send();
    }
}
