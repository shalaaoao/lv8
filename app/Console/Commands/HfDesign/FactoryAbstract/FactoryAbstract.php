<?php

namespace App\Console\Commands\HfDesign\FactoryAbstract;

use Illuminate\Console\Command;

class FactoryAbstract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:factory-abstract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 抽象工厂模式';

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
        $a = (new NYPizzaStore())->orderPizza('cheese');
    }
}

/**
 * 披萨的原料工厂接口
 */
interface PizzaIngredientFactory
{
    /**
     * @param Dough $dough
     * @return string
     */
    public function createDough(): string;

    /**
     * 创建酱汁
     * @return string
     */
    public function createSauce(): string;

    /**
     * 创建芝士
     * @return string
     */
    public function createCheese(): string;

    /**
     * 创建素食
     * @return string
     */
    public function createVeggies(): string;

    /**
     * 创建辣香肠
     * @return string
     */
    public function createPepperoni(): string;

    /**
     * 创建蛤蜊
     * @return string
     */
    public function createClam(): string;
}

/**
 * 纽约披萨原料工厂
 */
class NYPizzaIngredientFactory implements PizzaIngredientFactory
{
    public function createDough(): string
    {
        // 纽约用厚面皮
        return (new ThickCrustDough())->make();
    }

    public function createSauce(): string
    {
        return '';
    }

    public function createCheese(): string
    {
        return '';
    }

    public function createVeggies(): string
    {
        return '';
    }

    public function createPepperoni(): string
    {
        return '';
    }

    public function createClam(): string
    {
        return '';
    }
}

/**
 * 芝加哥披萨原料工厂
 */
class ChicagoPizzaIngredientFactory implements PizzaIngredientFactory
{
    public function createDough(): string
    {
        // 芝加哥工厂就用薄的面皮
        return (new ThinCrustDough())->make();
    }

    public function createSauce(): string
    {
        return '';
    }

    public function createCheese(): string
    {
        return '';
    }

    public function createVeggies(): string
    {
        return '';
    }

    public function createPepperoni(): string
    {
        return '';
    }

    public function createClam(): string
    {
        return '';
    }
}


/**
 * 面团接口
 */
interface Dough
{
    public function make(): string;
}

/**
 * 厚皮面团
 */
class ThickCrustDough implements Dough
{
    public function make(): string
    {
        return 'Thick Crust Dough make...';
    }
}

/**
 * 薄皮面团
 */
class ThinCrustDough implements Dough
{
    public function make(): string
    {
        return 'Thin Crust Dough make...';
    }
}

// TODO 酱料、芝士、蛤蜊接口及各种实现类

/**
 * 披萨的抽象类
 */
abstract class Pizza
{
    protected PizzaIngredientFactory $pizzaIngredientFactory;

    public function __construct(PizzaIngredientFactory $pizzaIngredientFactory)
    {
        $this->pizzaIngredientFactory = $pizzaIngredientFactory;
    }

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
     * 芝士
     * @var string
     */
    private string $cheese;

    /**
     * 蛤蜊
     * @var string
     */
    private string $clam;

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
     * @param string $cheese
     */
    public function setCheese(string $cheese): void
    {
        $this->cheese = $cheese;
    }

    /**
     * @param string $clam
     */
    public function setClam(string $clam): void
    {
        $this->clam = $clam;
    }

    /**
     * @param array $toppings
     */
    public function setToppings(string $toppings): void
    {
        $this->toppings[] = $toppings;
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

    abstract public function prepare(): void;
}

/**
 * 芝士披萨的具体实现类
 */
class CheesePizza extends Pizza
{
    public function prepare(): void
    {
        dump("Preparing ".$this->getName().'...');

        $this->setDough($this->pizzaIngredientFactory->createDough());
        $this->setSauce($this->pizzaIngredientFactory->createSauce());
        $this->setCheese($this->pizzaIngredientFactory->createCheese());
    }
}

/**
 * 蛤蜊披萨的具体实现类
 */
class ClamPizza extends Pizza
{
    public function prepare(): void
    {
        dump("Preparing ".$this->getName().'...');
        $this->setDough($this->pizzaIngredientFactory->createDough());
        $this->setSauce($this->pizzaIngredientFactory->createSauce());
        $this->setCheese($this->pizzaIngredientFactory->createCheese());
        $this->setClam($this->pizzaIngredientFactory->createClam());
    }
}

/**
 * 各地工厂的抽象
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
 * 纽约的披萨工厂
 */
class NYPizzaStore extends PizzaStore
{
    public function createPizza(string $type): Pizza
    {
        $ingredientFactory = new NYPizzaIngredientFactory();

        if ($type == 'cheese') {
            $pizza =  (new CheesePizza($ingredientFactory));
            $pizza->setName('New York Style Cheese Pizza');
        } elseif ($type == 'clam') {
            $pizza = (new ClamPizza($ingredientFactory));
            $pizza->setName('New York Style Clam Pizza');
        } else {
            throw new \Exception('NYPizzaStore不支持的type');
        }

        return $pizza;
    }
}
