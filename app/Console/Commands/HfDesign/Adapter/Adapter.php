<?php

namespace App\Console\Commands\HfDesign\Adapter;

use Illuminate\Console\Command;

class Adapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:adapter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 适配器模式';

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
        // 对象适配器 - 基于组合
        $turkeyAdapter = new TurkeyAdapterComposition(new WildTurkey());
        $turkeyAdapter->quack();
        $turkeyAdapter->fly();

        // 类适配器 - 基于继承
        $turkeyAdapter = new TurkeyAdapterInherit();
        $turkeyAdapter->quack();
        $turkeyAdapter->fly();
    }
}

/**
 * 鸭子 - 接口
 */
interface Duck
{
    public function quack(): void;

    public function fly(): void;
}

/**
 * 绿头鸭
 */
class MallardDuck implements Duck
{
    public function quack(): void
    {
        dump("Quack");
    }

    public function fly(): void
    {
        dump("I'm flying");
    }
}

/**
 * 火鸡 - 接口
 */
interface Turkey
{
    /**
     * 火鸡不会呱呱叫，只会咯咯叫
     */
    public function gobble(): void;

    /**
     * 火鸡会飞，虽然飞的不远
     */
    public function fly(): void;
}

/**
 * 野生火鸡
 */
class WildTurkey implements Turkey
{
    public function gobble(): void
    {
        dump("Gobble gobble...");
    }

    public function fly(): void
    {
        dump("I'm flying a short distance...");
    }
}

/**
 * 火鸡对鸭的适配器 - 基于组合，对象适配器
 */
class TurkeyAdapterComposition implements Duck
{
    private Turkey $turkey;

    public function __construct(Turkey $turkey)
    {
        $this->turkey = $turkey;
    }

    public function quack(): void
    {
        $this->turkey->gobble();
    }

    public function fly(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->turkey->fly();
        }
    }
}

/**
 * 火鸡对鸭的适配器 - 基于继承，类适配器
 */
class TurkeyAdapterInherit extends WildTurkey implements Duck
{
    public function quack(): void
    {
        $this->gobble();
    }

    public function fly(): void
    {
        for ($i = 0; $i < 5; $i++) {
            parent::fly();
        }
    }
}
