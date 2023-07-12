<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;


class FactorySimple extends Command
{
    protected $signature   = 'design:factory-simple';
    protected $description = '设计模式-简单工厂';

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

// 所有服务商的类，都要实现的方法：发送短信、app推送
// 定好基调：目的更多的是让代码更具备可读性、和书写更加严谨
abstract class FactorySimpleMessage
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;

        $this->loadConfig();
    }

    abstract public function loadConfig();

    abstract public function send(string $msg);

    abstract public function appPush();
}

class AliYunMessage extends FactorySimpleMessage
{
    /**
     * 配置相关的属性
     * @var string
     */
    private string $key;
    private string $appId;

    public function loadConfig()
    {
        // 加载常规配置
    }

    public function setAAAA(int $userId): self
    {
        // 根据参数加载一些特殊的参数
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

class BaiduYunMessage extends  FactorySimpleMessage
{

    public function loadConfig()
    {
        // 加载常规配置
    }

    public function setBBBB(int $clientId): self
    {
        // 根据参数加载一些特殊的配置
        return $this;
    }

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

class JiguangMessage extends  FactorySimpleMessage
{
    public function loadConfig()
    {
        // 加载常规配置
    }

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

// 服务商的简单工厂
class MessageFactory
{
    public static function createFactory($type, int $userId)
    {
        // 极端情况下，这里创建对象会比较困难。
        switch ($type) {
            case FactorySimple::TYPE_ALI:

                return (new AliYunMessage(['config']))->setAAAA($userId);
            case FactorySimple::TYPE_BAIDU:

                // 比如这里需要setBBBB
                return (new BaiduYunMessage(['config']))->setBBBB(1);
            case FactorySimple::TYPE_JIGUANG:

                return new JiguangMessage(['config']);
            default:
                return null;
        }
    }
}
