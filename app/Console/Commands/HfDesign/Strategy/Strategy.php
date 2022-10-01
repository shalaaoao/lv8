<?php

namespace App\Console\Commands\HfDesign\Strategy;

use Illuminate\Console\Command;

class Strategy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:strategy';

    /**59138
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 策略模式';

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
        $duck = new Duck();
        $duck->setFlyBehavior(new FlyBad());
        $duck->setQuackBehavior(new QuackA());
        $duck->getDuckDetail();
    }
}

interface IFlyBehavior
{
    public function fly();
}

class FlyBad implements IFlyBehavior
{
    public function fly()
    {
        return '不会飞';
    }
}

class FlyRocket implements IFlyBehavior
{
    public function fly()
    {
        return '像火箭一样飞';
    }
}

interface IQuackBehavior
{
    public function quack();
}

class QuackA implements IQuackBehavior
{
    public function quack()
    {
        return 'AAA的叫';
    }
}

class QuackB implements IQuackBehavior
{
    public function quack()
    {
        return 'BBB的叫';
    }
}

class Duck
{
    private IFlyBehavior $flyBehavior;

    /**
     * @param IFlyBehavior $flyBehavior
     */
    public function setFlyBehavior(IFlyBehavior $flyBehavior): void
    {
        $this->flyBehavior = $flyBehavior;
    }

    private IQuackBehavior $quackBehavior;

    /**
     * @param IQuackBehavior $quackBehavior
     */
    public function setQuackBehavior(IQuackBehavior $quackBehavior): void
    {
        $this->quackBehavior = $quackBehavior;
    }

    public function getDuckDetail()
    {
        echo "我是一只鸭：" . PHP_EOL . "我的飞行行为：" . $this->flyBehavior->fly() . PHP_EOL . "我的叫声:" . $this->quackBehavior->quack() . PHP_EOL;
    }

}

