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
    public function handle()
    {

        // 当前业务需要使用极光
        echo $message = MessageFactory::createFactory('Ali')
                                      ->send('您又新的短消息，请查收~'), PHP_EOL;
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
        switch ($type) {
            case 'Ali':
                return new AliYunMessage();
            case 'BD':
                return new BaiduYunMessage();
            case 'JG':
                return new JiguangMessage();
            default:
                return null;
        }
    }
}
