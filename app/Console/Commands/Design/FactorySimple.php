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
        // 当前业务需要使用极光
        echo MessageFactory::createFactory(self::TYPE_ALI, $userId = 1)
                           ->send('您又新的短消息，请查收~'), PHP_EOL;
    }
}

interface FactorySimpleMessage
{
    public function send(string $msg);

    public function appPush();
}

class AliYunMessage implements FactorySimpleMessage
{
    public function __construct()
    {
        // 加载基础配置
    }

    public function setAAAA(int $userId)
    {
        // 根据参数加载一些特殊的配置
        return $this;
    }

    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '阿里云短信（原阿里大鱼）发送成功！短信内容：' . $msg;
    }

    public function appPush()
    {

    }
}

class BaiduYunMessage implements FactorySimpleMessage
{
    // 同上加载配置

    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '百度SMS短信发送成功！短信内容：' . $msg;
    }

    public function appPush()
    {

    }
}

class JiguangMessage implements FactorySimpleMessage
{
    // 同上加载配置


    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '极光短信发送成功！短信内容：' . $msg;
    }

    public function appPush()
    {

    }
}

class MessageFactory
{
    public static function createFactory($type, int $userId)
    {
        // 极端情况下，这里创建对象会比较困难。
        switch ($type) {
            case FactorySimple::TYPE_ALI:

                return (new AliYunMessage())->setAAAA($userId);
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
