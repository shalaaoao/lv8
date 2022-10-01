<?php

namespace App\Console\Commands\HfDesign\Decorate;

use Illuminate\Console\Command;

class Decorate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:decorate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 装饰者模式';

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
        $espresso = (new Espresso());
        dump($espresso->getDescription());
        dump($espresso->cost());

        $espresso = (new Milk($espresso));
        $espresso = (new Sugar($espresso));
        dump($espresso->getDescription());
        dump($espresso->cost());
    }
}

/**
 * 饮料抽象类
 */
abstract class Beverage
{
    protected Beverage $beverage;

    protected string $description = '';

    abstract protected function cost();

    protected function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

/**
 * 具体的饮料 - 浓缩咖啡
 */
class Espresso extends Beverage
{
    public function __construct()
    {
        $this->setDescription($this->getDescription() . ', Espresso');
    }

    public function cost()
    {
        return 24;
    }
}

/**
 * 具体的饮料 - 拿铁
 */
class Latte extends Beverage
{
    public function __construct()
    {
        $this->setDescription($this->getDescription() . ', Latte');
    }

    public function cost()
    {
        return 15;
    }
}

/**
 * 调料抽象类
 */
interface CondimentsDecorate
{
    public function getDescription(): string;
}

/**
 * 调料 - 牛奶
 */
class Milk extends Beverage implements CondimentsDecorate
{
    public function __construct(Beverage $beverage)
    {
        $this->beverage = $beverage;
    }

    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ',Milk';
    }

    public function cost()
    {
        return $this->beverage->cost() + 2;
    }
}

/**
 * 调料 - 白糖
 */
class Sugar extends Beverage implements CondimentsDecorate
{
    public function __construct(Beverage $beverage)
    {
        $this->beverage = $beverage;
    }

    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ',Sugar';
    }

    public function cost()
    {
        return $this->beverage->cost() + 3;
    }
}
