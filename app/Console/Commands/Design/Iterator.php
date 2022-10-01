<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Iterator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:iterator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-迭代器模式';

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
        // 要发的短信号码列表
        $mobileList = [
            '11111',
            '22222',
            '33333',
            '44444',
        ];

        // A服务器脚本发送正向的一半
        $serverA   = new BaseMessage();
        $iteratorA = $serverA->createIterator(AscMsgIterator::class, $mobileList);

        while (!$iteratorA->isDone()) {
            echo $iteratorA->currentItem(), PHP_EOL;
            $iteratorA->next();
        }

        // B服务器脚本发送逆向的一半
        $serverB   = new BaseMessage();
        $iteratorB = $serverB->createIterator(DescMsgIterator::class, $mobileList);

        while (!$iteratorB->isDone()) {
            echo $iteratorB->currentItem(), PHP_EOL;
            $iteratorB->next();
        }
    }
}

interface IMsgIterator
{
    public function first();

    public function next();

    public function isDone();

    public function currentItem();
}

/**
 * 基类迭代器
 */
class BaseMsgIterator implements IMsgIterator
{
    protected array $list;
    protected int   $index;

    protected function __construct(array $list)
    {
        $this->index = 0;
    }

    public function first()
    {
        $this->index = 0;
    }

    public function next()
    {
        $this->index++;
    }

    public function isDone()
    {
        return $this->index >= count($this->list);
    }

    public function currentItem()
    {
        return $this->list[$this->index];
    }
}

/**
 * 正向迭代器
 */
class AscMsgIterator extends BaseMsgIterator
{
    public function __construct(array $list)
    {
        parent::__construct($list);
        $this->list = $list;
    }
}

/**
 * 逆向迭代器
 */
class DescMsgIterator extends BaseMsgIterator
{
    public function __construct(array $list)
    {
        parent::__construct($list);
        $this->list = array_reverse($list);
    }
}

interface IMessage
{
    public function createIterator(string $iterator, array $list);
}

class BaseMessage implements IMessage
{
    public function createIterator(string $iterator, array $list)
    {
        return new $iterator($list);
    }
}
