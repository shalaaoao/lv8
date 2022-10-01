<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Adapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:adapter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-适配器模式';

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
        // 基于继承
        (new Adaptor1())->f1();
        (new Adaptor1())->f2();
        (new Adaptor1())->fc();

        // 基于组合
        (new Adaptor2(new Adaptee()))->f1();
        (new Adaptor2(new Adaptee()))->f2();
        (new Adaptor2(new Adaptee()))->fc();
    }
}

interface ITarget
{
    public function f1(): void;
    public function f2(): void;
    public function fc(): void;
}

class Adaptee
{
    public function fa(): void {}
    public function fb(): void {}
    public function fc(): void {}
}

// 类适配器：基于继承
class Adaptor1 extends Adaptee implements ITarget
{

    public function f1(): void
    {
        $this->fa();
    }

    public function f2(): void
    {
        // ... 重新实现f2()...
    }

    // 这里fc()不要实现，直接继承自Adaptee,这是跟对象适配器最大的不同点
}

// 对象适配器：基于组合
class Adaptor2 implements ITarget
{
    private Adaptee $adaptee;

    public function __construct(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function f1(): void
    {
        $this->adaptee->fa(); // 委托给Adaptee
    }

    public function f2(): void
    {
        // ... 重新实现f2() ...
    }

    public function fc(): void
    {
        $this->adaptee->fc();
    }
}
