<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Strategy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:strategy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式：策略模式';

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
        $context = new SContext(new ConcreteStrategyA());
        $context->ContextInterface();

        $context = new SContext(new ConcreteStrategyB());
        $context->ContextInterface();

        $context = new SContext(new ConcreteStrategyC());
        $context->ContextInterface();
    }
}

interface IStrategy
{
    function AlgorithmInterface();
}

class ConcreteStrategyA implements IStrategy
{
    function AlgorithmInterface()
    {
        echo "算法A", PHP_EOL;
    }
}

class ConcreteStrategyB implements IStrategy
{
    function AlgorithmInterface()
    {
        echo "算法B", PHP_EOL;
    }
}

class ConcreteStrategyC implements IStrategy
{
    function AlgorithmInterface()
    {
        echo "算法C", PHP_EOL;
    }
}

class SContext
{
    private $strategy;

    function __construct(IStrategy $s)
    {
        $this->strategy = $s;
    }

    function ContextInterface()
    {
        $this->strategy->AlgorithmInterface();
    }
}
