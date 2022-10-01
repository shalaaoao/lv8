<?php

namespace App\Console\Commands\Oop;

use Illuminate\Console\Command;

class Abst extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oop:abst';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'abstract语法测试';

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

    }
}

abstract class BaseAb
{
    abstract protected function a($param);
    protected $aaa;
}

class ChildAb extends BaseAb {
    public function a($b=1)
    {

    }

    public $aaa=2;
}

