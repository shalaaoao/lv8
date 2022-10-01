<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Cmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:cmd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-命令模式';

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
        $sendAliYun = new SendAliYun();
        $sendAliYun->setReceiver(new SendAliYunMsg());

        $sendJiGuang = new SendJiGuang();
        $sendAliYun->setReceiver(new SendJiGuangMsg());

        $sendMsg = new SendMsg();
        $sendMsg->setCommand($sendAliYun);
        $sendMsg->setCommand($sendJiGuang);

        $sendMsg->send('这次要搞个大活动，快来注册吧！！');
    }
}

class SendMsg
{
    private $command = [];

    public function setCommand(ACommand $command)
    {
        $this->command[] = $command;
    }

    public function send($msg)
    {
        foreach ($this->command as $command) {
            $command->execute($msg);
        }
    }
}

abstract class ACommand
{
    protected array $receiver = [];

    public function setReceiver(ISendMsg $receiver)
    {
        $this->receiver[] = $receiver;
    }

    abstract public function execute($msg);
}

class SendAliYun extends ACommand
{
    public function execute($msg)
    {
        foreach ($this->receiver as $receiver) {
            $receiver->action($msg);
        }
    }
}

class SendJiGuang extends ACommand
{
    public function execute($msg)
    {
        foreach ($this->receiver as $receiver) {
            $receiver->action($msg);
        }
    }
}

interface ISendMsg
{
    public function action(string $msg);
}

class SendAliYunMsg implements ISendMsg
{
    public function action(string $msg)
    {
        echo '【阿X云短信】发送：' . $msg, PHP_EOL;
    }
}

class SendJiGuangMsg implements ISendMsg
{
    public function action(string $msg)
    {
        echo '【极X短信】发送：' . $msg, PHP_EOL;
    }
}
