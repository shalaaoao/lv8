<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class FactoryAbstract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:factory-abstract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-抽象工厂';

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
        // 当前业务需要使用阿里云
        $factory = new AliYunFactoryAbstract();
// $factory = new BaiduYunFactoryAbstract();
// $factory = new JiguangFactoryAbstract();
        $message = $factory->createMessage();
        $push    = $factory->createPush();
        echo $message->send('您已经很久没有登录过系统了，记得回来哦！'), PHP_EOL;
        echo $push->send('您有新的红包已到帐，请查收！'), PHP_EOL;
    }
}

interface IMessageFactoryAbstract
{
    public function send(string $msg);
}

class AliYunMessageAbstract implements IMessageFactoryAbstract
{
    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '阿里云短信（原阿里大鱼）发送成功！短信内容：' . $msg;
    }
}

class BaiduYunMessageAbstract implements IMessageFactoryAbstract
{
    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '百度SMS短信发送成功！短信内容：' . $msg;
    }
}

class JiguangMessageAbstract implements IMessageFactoryAbstract
{
    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '极光短信发送成功！短信内容：' . $msg;
    }
}

interface IPush
{
    public function send(string $msg);
}

class AliYunPush implements IPush
{
    public function send(string $msg)
    {
        // 调用接口，发送客户端推送
        // xxxxx
        return '阿里云Android&iOS推送发送成功！推送内容：' . $msg;
    }
}

class BaiduYunPush implements IPush
{
    public function send(string $msg)
    {
        // 调用接口，发送客户端推送
        // xxxxx
        return '百度Android&iOS云推送发送成功！推送内容：' . $msg;
    }
}

class JiguangPush implements IPush
{
    public function send(string $msg)
    {
        // 调用接口，发送客户端推送
        // xxxxx
        return '极光推送发送成功！推送内容：' . $msg;
    }
}


interface IMessageFactoryFactoryAbstract
{
    public function createMessage();

    public function createPush();
}

class AliYunFactoryAbstract implements IMessageFactoryFactoryAbstract
{
    public function createMessage()
    {
        return new AliYunMessage();
    }

    public function createPush()
    {
        return new AliYunPush();
    }
}

class BaiduYunFactoryAbstract implements IMessageFactoryFactoryAbstract
{
    public function createMessage()
    {
        return new BaiduYunMessage();
    }

    public function createPush()
    {
        return new BaiduYunPush();
    }
}

class JiguangFactoryAbstract implements IMessageFactoryFactoryAbstract
{
    public function createMessage()
    {
        return new JiguangMessage();
    }

    public function createPush()
    {
        return new JiguangPush();
    }
}
