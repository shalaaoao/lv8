<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class FactorySimple extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:factory-simple';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-简单工厂';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    const TYPE_ALI     = 1;
    const TYPE_BAIDU   = 2;
    const TYPE_JIGUANG = 3;

    public function handle()
    {
        // 2B青年写法


        // 当前业务需要使用极光
        echo $message = MessageFactory::createFactory(self::TYPE_ALI)
                                      ->send('您又新的短消息，请查收~'), PHP_EOL;
    }
}

// 普通2B青年写法
class SendCommon2B{

    public static function send(int $type, array $data)
    {
        switch ($type) {
            case FactorySimple::TYPE_ALI:

                // 对接阿里云，各种配置加载...
                // curl

            case FactorySimple::TYPE_BAIDU:

                // 同上，对接百度云
            case FactorySimple::TYPE_JIGUANG:

                // 同上，对接极光

            default:
                return null;
        }
    }
}


interface FactorySimpleMessage
{
    public function send(string $msg);
}

class AliYunMessage implements FactorySimpleMessage
{
    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '阿里云短信（原阿里大鱼）发送成功！短信内容：' . $msg;
    }
}

class BaiduYunMessage implements FactorySimpleMessage
{
    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '百度SMS短信发送成功！短信内容：' . $msg;
    }
}

class JiguangMessage implements FactorySimpleMessage
{
    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '极光短信发送成功！短信内容：' . $msg;
    }
}

class MessageFactory
{
    public static function createFactory($type)
    {
        // 极端情况下，这里创建对象会比较困难。
        switch ($type) {
            case FactorySimple::TYPE_ALI:

                // 比如这里需要setAAAA
                return new AliYunMessage();
            case FactorySimple::TYPE_BAIDU:

                // 比如这里需要setBBBB
                return new BaiduYunMessage();
            case FactorySimple::TYPE_JIGUANG:
                return new JiguangMessage();
            default:
                return null;
        }
    }
}
