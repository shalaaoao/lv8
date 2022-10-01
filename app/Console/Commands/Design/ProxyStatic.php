<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class ProxyStatic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:proxy-static';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-代理模式-静态代理';

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
        $sendMessage = new ProxySendMessage(new RealSendMessage());
        $sendMessage->send();
    }
}

interface SendMessage
{
    public function send();
}

class RealSendMessage implements SendMessage
{
    public function send()
    {
        echo "短信发送中..." . PHP_EOL;
    }
}

class ProxySendMessage implements SendMessage
{
    private RealSendMessage $realSendMessage;

    public function __construct(RealSendMessage $realSendMessage)
    {
        $this->realSendMessage = $realSendMessage;
    }

    public function send()
    {
        echo "短信发送开始：" . PHP_EOL;
        $this->realSendMessage->send();
        echo '短信发送结束：' . PHP_EOL;
    }
}
