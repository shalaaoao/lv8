<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Factory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:factory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-工厂模式';

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
        // 当前业务需要使用百度云
        $factory = new BaiduYunFactory();
        $message = $factory->getMessage();
        echo $message->send('您有新的短消息，请查收'), PHP_EOL;
    }
}


interface IMessageFactory
{
    public function send(string $msg);
}

class IAliYunMessage implements IMessageFactory
{
    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '阿里云短信（原阿里大鱼）发送成功！短信内容：' . $msg;
    }
}

class IBaiduYunMessage implements IMessageFactory
{
    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '百度SMS短信发送成功！短信内容：' . $msg;
    }
}

class IJiguangMessage implements IMessageFactory
{
    public function send(string $msg)
    {
        // 调用接口，发送短信
        // xxxxx
        return '极光短信发送成功！短信内容：' . $msg;
    }
}

abstract class AMessageFactory
{
    abstract protected function factoryMethod(): IMessageFactory;

    public function getMessage(): IMessageFactory
    {
        return $this->factoryMethod();
    }
}

class AliYunFactory extends AMessageFactory
{
    protected function factoryMethod(): IMessageFactory
    {
        return new IAliYunMessage();
    }
}

class BaiduYunFactory extends AMessageFactory
{
    protected function factoryMethod(): IMessageFactory
    {
        return new IBaiduYunMessage();
    }
}

class JiguangFactory extends AMessageFactory
{
    protected function factoryMethod(): IMessageFactory
    {
        return new IJiguangMessage();
    }
}
