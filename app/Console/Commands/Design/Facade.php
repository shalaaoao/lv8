<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Facade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:facade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-门面模式';

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
        $facade = new FacadeCs();
        $facade->methodA();
        $facade->methodB();
    }
}

class FacadeCs
{
    private SubSystem1 $subSystem1;
    private SubSystem2 $subSystem2;
    private SubSystem3 $subSystem3;

    public function __construct()
    {
        $this->subSystem1 = new SubSystem1();
        $this->subSystem2 = new SubSystem2();
        $this->subSystem3 = new SubSystem3();
    }

    public function methodA()
    {
        $this->subSystem1->method1();
        $this->subSystem2->method2();
    }

    public function methodB()
    {
        $this->subSystem2->method2();
        $this->subSystem3->method3();
    }
}

class SubSystem1
{
    public function method1()
    {
        dump('子系统方法1');
    }
}

class SubSystem2
{
    public function method2()
    {
        dump('子系统方法2');
    }
}

class SubSystem3
{
    public function method3()
    {
        dump('子系统方法3');
    }
}


