<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Bridge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:bridge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-桥接模式';

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
        (new SeverNotification((new TelephoneMsgSender(['13917836275']))))->notify('爆炸了');
        (new UrgencyNotification((new EmailMsgSender(['605536038@qq.com']))))->notify('爆炸了');
    }
}

interface MsgSender
{
    public function send(string $message);
}

class TelephoneMsgSender implements MsgSender
{
    private array $telephones;

    public function __construct(array $telephones)
    {
        $this->telephones = $telephones;
    }

    /**
     * Override
     * @param string $message
     * @return mixed
     */
    public function send(string $message)
    {

    }
}

class EmailMsgSender implements MsgSender
{
    // 与TelephoneMsgSender代码结构类似，所以省略...

    /**
     * Override
     * @param string $message
     * @return mixed
     */
    public function send(string $message)
    {

    }
}

class WechantMsgSender implements MsgSender
{
    // 与TelephoneMsgSender代码结构类似，所以省略...

    /**
     * Override
     * @param string $message
     * @return mixed
     */
    public function send(string $message)
    {

    }
}

abstract class Notification
{
    protected MsgSender $msgSender;

    public function __construct(MsgSender $msgSender)
    {
        $this->msgSender = $msgSender;
    }

    abstract public function notify(string $message): void;
}

class SeverNotification extends Notification
{
    public function __construct(MsgSender $msgSender)
    {
        parent::__construct($msgSender);
    }

    public function notify(string $message): void
    {
        $this->msgSender->send($message);
        dump(__CLASS__ . ':' . $message);
    }
}

class UrgencyNotification extends Notification
{
    // 与SevereNotification代码结构类似，所以省略...

    public function notify(string $message): void
    {
        $this->msgSender->send($message);
        dump(__CLASS__ . ':' . $message);
    }
}

class NormalNotification extends Notification
{
    // 与SevereNotification代码结构类似，所以省略...

    public function notify(string $message): void
    {
        $this->msgSender->send($message);
        dump(__CLASS__ . ':' . $message);
    }
}

class TrivialNotification extends Notification
{
    // 与SevereNotification代码结构类似，所以省略...

    public function notify(string $message): void
    {
        $this->msgSender->send($message);
        dump(__CLASS__ . ':' . $message);
    }
}
