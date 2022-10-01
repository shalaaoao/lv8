<?php

namespace App\Console\Commands\HfDesign\Factory;

use Illuminate\Console\Command;

class Factory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:factory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 工厂模式';

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
        $nyStore = new NYPizzaStore();
        $nyStore->orderPizza('cheese');
    }
}

/**
 * 各地工厂的抽象
 * Class PizzaStore
 * @package App\Console\Commands\HfDesign\Factory
 */
abstract class PizzaStore
{
    public function orderPizza(string $type): Pizza
    {
        $pizza = $this->createPizza($type);
        $pizza->prepare();
        $pizza->bake();
        $pizza->cut();
        $pizza->box();

        return $pizza;
    }

    abstract public function createPizza(string $type): Pizza;
}

/**
 * 纽约 - 制造披萨的工厂
 * Class NYPizzaStore
 * @package App\Console\Commands\HfDesign\Factory
 */
class NYPizzaStore extends PizzaStore
{
    public function createPizza(string $type): Pizza
    {
        switch ($type) {
            case 'cheese':
                return new NYCheesePizza();
            case 'veggie':
                return new NYVeggiePizza();
            default:
                throw new \Exception('NYPizzaStore 错误的披萨类型');
        }
    }
}

/**
 * 芝加哥 - 制造披萨的工厂
 * Class ChicagoPizzaStore
 * @package App\Console\Commands\HfDesign\Factory
 */
class ChicagoPizzaStore extends PizzaStore
{
    public function createPizza(string $type): Pizza
    {
        switch ($type) {
            case 'cheese':
//                return new ChicagoCheesePizza();
            case 'veggie':
//                return new ChicagoVeggiePizza();
            default:
                throw new \Exception('NYPizzaStore 错误的披萨类型');
        }
    }
}

/**
 * 披萨的抽象
 * Class Pizza
 * @package App\Console\Commands\HfDesign\Factory
 */
abstract class Pizza
{
//    abstract public function prepare();
//
//    abstract public function bake();
//
//    abstract public function cut();
//
//    abstract public function box();

    /**
     * 名称
     * @var string
     */
    private string $name;

    /**
     * 面团
     * @var string
     */
    private string $dough;

    /**
     * 酱汁
     * @var string
     */
    private string $sauce;

    /**
     * 配料
     * @var array
     */
    private array $toppings;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $dough
     */
    public function setDough(string $dough): void
    {
        $this->dough = $dough;
    }

    /**
     * @param string $sauce
     */
    public function setSauce(string $sauce): void
    {
        $this->sauce = $sauce;
    }

    /**
     * @param array $toppings
     */
    public function setToppings(string $toppings): void
    {
        $this->toppings[] = $toppings;
    }


    public function prepare()
    {
        dump("Preparing {$this->name}...");
        dump("Tossing dough...");
        dump("Adding sauce...");
        dump("Adding toppings...");

        $toppingsStr = '';
        foreach ($this->toppings as $v) {
            $toppingsStr .= $v . ' ';
        }
        dump($toppingsStr);
    }

    public function bake()
    {
        dump("Bake for 25 minutes at 350");
    }

    public function cut()
    {
        dump("Cutting the pizza into diagonal slices");
    }

    public function box()
    {
        dump("Place pizza in official PizzaStore box");
    }
}

/**
 * 纽约芝士披萨 - 具体的某种披萨
 * Class CheesePizza
 * @package App\Console\Commands\HfDesign\Factory
 */
class NYCheesePizza extends Pizza
{
    public function prepare()
    {
        $this->setName('NY Cheese Pizza');
        $this->setDough('NY Cheese Dough');
        $this->setSauce('NY Cheese Sauce');
        $this->setToppings('NY Cheese Toppings1');
        $this->setToppings('NY Cheese Toppings2');
    }

    public function bake()
    {
        // 重写父类的bake方法
        dump("NY Cheese rewrite bake function");
    }
//
//    public function cut()
//    {
//        echo "CheesePizza cut", PHP_EOL;
//    }
//
//    public function box()
//    {
//        echo "CheesePizza box", PHP_EOL;
//    }
}


/**
 * 纽约素食披萨 - 具体的某种披萨
 * Class VeggiePizza
 * @package App\Console\Commands\HfDesign\Factory
 */
class NYVeggiePizza extends Pizza
{
    public function prepare()
    {
        $this->setName('NY Veggie Pizza');
        $this->setDough('NY Veggie Dough');
        $this->setSauce('NY Veggie Sauce');
        $this->setToppings('NY Veggie Toppings1');
        $this->setToppings('NY Veggie Toppings2');
    }

//    public function bake()
//    {
//        // TODO: Implement bake() method.
//    }
//
//    public function cut()
//    {
//        // TODO: Implement cut() method.
//    }
//
//    public function box()
//    {
//        // TODO: Implement box() method.
//    }
}
