<?php

namespace App\Console\Commands\HfDesign\FactorySimple;

use Illuminate\Console\Command;

class FactorySimple extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:factory-simple';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 简单工厂';

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
        // 获取Pizza对象
        $pizza = (new SimplePizzaFactory())->createPizza('cheese');

        // 使用对象的方法
        $pizza->prepare();
        $pizza->bake();
        $pizza->cut();
        $pizza->box();
    }
}

/**
 * 生成披萨类的工厂类
 * Class SimplePizzaFactory
 * @package App\Console\Commands\HfDesign\Factory
 */
class SimplePizzaFactory
{
    private Pizza $pizza;

    public function createPizza(string $type): Pizza
    {
        switch ($type) {
            case 'cheese':
                $this->pizza = new CheesePizza();
                break;
            case 'veggie':
                $this->pizza = new VeggiePizza();
                break;
            default:
                throw new \Exception('错误的披萨类型');
        }

        return $this->pizza;
    }
}

/**
 * 披萨的抽象
 * Class Pizza
 * @package App\Console\Commands\HfDesign\Factory
 */
abstract class Pizza
{
    abstract public function prepare();

    abstract public function bake();

    abstract public function cut();

    abstract public function box();
}

/**
 * 芝士披萨 - 具体的某种披萨
 * Class CheesePizza
 * @package App\Console\Commands\HfDesign\Factory
 */
class CheesePizza extends Pizza
{

    public function prepare()
    {
        echo "CheesePizza prepare", PHP_EOL;
    }

    public function bake()
    {
        echo "CheesePizza bake", PHP_EOL;
    }

    public function cut()
    {
        echo "CheesePizza cut", PHP_EOL;
    }

    public function box()
    {
        echo "CheesePizza box", PHP_EOL;
    }
}

/**
 * 素食披萨 - 具体的某种披萨
 * Class VeggiePizza
 * @package App\Console\Commands\HfDesign\Factory
 */
class VeggiePizza extends Pizza
{

    public function prepare()
    {
        // TODO: Implement prepare() method.
    }

    public function bake()
    {
        // TODO: Implement bake() method.
    }

    public function cut()
    {
        // TODO: Implement cut() method.
    }

    public function box()
    {
        // TODO: Implement box() method.
    }
}
