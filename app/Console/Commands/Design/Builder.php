<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Builder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:builder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-建造者模式';

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
        $obj = new Director();
        echo $obj->builder(new BikeBuilder()) . PHP_EOL;
        echo $obj->builder(new CarBuilder()) . PHP_EOL;
    }
}

class Director
{

    public function builder(BuilderInterface $builder)
    {
        $builder->a();
        $builder->b();
        return $builder->c();
    }
}

interface BuilderInterface
{
    public function a();

    public function b();

    public function c();
}

class BikeBuilder implements BuilderInterface
{
    public function a()
    {
        return 'bike-a';
    }

    public function b()
    {
        return 'bike-b';
    }

    public function c()
    {
        return 'bike-c';
    }
}

class CarBuilder implements BuilderInterface
{
    public function a()
    {
        return 'car-a';
    }

    public function b()
    {
        return 'car-b';
    }

    public function c()
    {
        return 'car-c';
    }
}
