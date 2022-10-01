<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Responsibility extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:responsibility';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-责任链模式';

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
        $handle1 = new ConcreteHandler1();
        $handle2 = new ConcreteHandler2();
        $handle3 = new ConcreteHandler3();

        $handle1->setSuccessor($handle2);
        $handle2->setSuccessor($handle3);

        $requests = ['你妹毛泽东嗷嗷', 'a', 2, [12]];

        foreach ($requests as $request) {
            dump($handle1->HandleRequest($request));
        }
    }
}

abstract class Handler
{
    protected Handler $successor;

    public function setSuccessor(Handler $successor)
    {
        $this->successor = $successor;
    }

    abstract public function HandleRequest($request);
}

class ConcreteHandler1 extends Handler
{
    public function HandleRequest($request)
    {
        if (is_numeric($request)) {
            return '请求参数是数字：' . $request;
        } else {
            return $this->successor->HandleRequest($request);
        }

        // 过滤敏感词
        $warnings = ['毛泽东', '领导人'];
        $request = str_replace($warnings, '*', $request);

        return $request;

//        return $this->successor->HandleRequest($request);
//
//        foreach ($warnings as $w) {
//
//            // 直接屏蔽做法
////            if (mb_strpos($request, $w) !== false) {
////                return '词汇中具有敏感词，禁止输出';
////            }
//
//            // 打*代替
//            $check = mb_strpos($request, $w);
//            dd($check);
//            if ($check !== false) {
//                $request = str_replace($check, '*', $request);
//
//                return $request;
//            }
//
//
//            return $this->successor->HandleRequest($request);
//        }
    }
}

class ConcreteHandler2 extends Handler
{
    public function HandleRequest($request)
    {
        if (is_string($request)) {
            return '请求参数是字符串：' . $request;
        } else {
            return $this->successor->HandleRequest($request);
        }
    }
}

class ConcreteHandler3 extends Handler
{
    public function HandleRequest($request)
    {
        return '我也不知道请求参数是啥' . gettype($request);
    }
}
