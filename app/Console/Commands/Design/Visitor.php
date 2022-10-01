<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Visitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:visitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-访问者模式';

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
        $o = new ObjectStructure();
        $o->Attach(new PushMessage());
        $o->Attach(new CSendMessage());

        $v1 = new AliYun();
        $v2 = new JiGuang();

        $o->Accept($v1);
        $o->Accept($v2);
    }
}
interface ServiceVisitor
{
    public function SendMsg(CSendMessage $s);
    function PushMsg(PushMessage $p);
}

class AliYun implements ServiceVisitor
{
    public function SendMsg(CSendMessage $s)
    {
        echo '阿里云发送短信！', PHP_EOL;
    }
    public function PushMsg(PushMessage $p)
    {
        echo '阿里云推送信息！', PHP_EOL;
    }
}

class JiGuang implements ServiceVisitor
{
    public function SendMsg(CSendMessage $s)
    {
        echo '极光发送短信！', PHP_EOL;
    }
    public function PushMsg(PushMessage $p)
    {
        echo '极光推送短信！', PHP_EOL;
    }
}

interface Message
{
    public function Msg(ServiceVisitor $v);
}

class PushMessage implements Message
{
    public function Msg(ServiceVisitor $v)
    {
        echo '推送脚本启动：';
        $v->PushMsg($this);
    }
}

class CSendMessage implements Message
{
    public function Msg(ServiceVisitor $v)
    {
        echo '短信脚本启动：';
        $v->SendMsg($this);
    }
}

class ObjectStructure
{
    private $elements = [];

    public function Attach(Message $element)
    {
        $this->elements[] = $element;
    }

    public function Detach(Message $element)
    {
        $position = 0;
        foreach ($this->elements as $e) {
            if ($e == $element) {
                unset($this->elements[$position]);
                break;
            }
            $position++;
        }
    }

    public function Accept(ServiceVisitor $visitor)
    {
        foreach ($this->elements as $e) {
            $e->Msg($visitor);
        }
    }

}

