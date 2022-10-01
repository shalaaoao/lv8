<?php

namespace App\Console\Commands\HfDesign\Composition;

use Illuminate\Console\Command;

class Composition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:composition';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 组合模式';

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
        // 创建所有菜单对象
        $menu1 = new Menu('name1', 'desc1');
        $menu2 = new Menu('name2', 'desc2');
        $menu11 = new Menu('name11', 'desc11');

        $allMenus = new Menu('all menus name', 'all menus desc');
        $allMenus->add($menu1);
        $allMenus->add($menu2);

        // 加入菜单项
        $menu1->add(new MenuItem('nameItem1', 'descItem1', true, 1));
        $menu11->add(new MenuItem('nameItem11', 'descItem11', false, 11));
        $menu1->add($menu11);

        // ...加入更多菜单项
        $menu2->add(new MenuItem('nameItem2', 'descItem2', false, 2));

        $waitress = new Waitress($allMenus);
        $waitress->printMenu();
    }
}

abstract class MenuComponent{}

/**
 * 菜单项
 * Class MenuItem
 * @package App\Console\Commands\HfDesign\Composition
 */
class MenuItem extends MenuComponent
{
    private string $name;
    private string $description;
    private bool   $vegetarian;
    private float  $price;

    /**
     * MenuItem constructor.
     * @param string $name
     * @param string $description
     * @param bool $vegetarian
     * @param float $price
     */
    public function __construct(string $name, string $description, bool $vegetarian, float $price)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->vegetarian  = $vegetarian;
        $this->price       = $price;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isVegetarian(): bool
    {
        return $this->vegetarian;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function print()
    {
        dump("MenuItem Print...");
        dump($this);
    }
}

class Menu extends MenuComponent
{
    private array  $menuComponents = [];
    private string $name;
    private string $description;

    public function __construct(string $name, string $description)
    {
        $this->name        = $name;
        $this->description = $description;
    }

    public function add(MenuComponent $menuComponent): self
    {
        $this->menuComponents[] = $menuComponent;
        return $this;
    }

    public function remove(MenuComponent $menuComponent): self
    {
        foreach ($this->menuComponents as $k => $val) {
            if ($val == $menuComponent) {
                unset($this->menuComponents[$k]);
            }
        }

        return $this;
    }

    public function getChild(int $i): MenuComponent
    {
        return $this->menuComponents[$i];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function print()
    {
//        dump("Menu Print...");
        foreach ($this->menuComponents as $val) {
            $val->print();
        }
    }
}

class Waitress
{
    private MenuComponent $allMenus;

    /**
     * Waitress constructor.
     * @param MenuComponent $allMenus
     */
    public function __construct(MenuComponent $allMenus)
    {
        $this->allMenus = $allMenus;
    }

    public function printMenu()
    {
        return $this->allMenus->print();
    }
}
