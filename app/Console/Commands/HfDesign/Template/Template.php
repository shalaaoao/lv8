<?php

namespace App\Console\Commands\HfDesign\Template;

use Illuminate\Console\Command;

class Template extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 模板模式';

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
        // 泡咖啡
        (new Coffee())->prepareRecipe();

        // 泡茶
        (new Tea())->prepareRecipe();
    }
}

class CaffeineBeverage
{
    /**
     * 准备咖啡因饮料的流程
     */
    public function prepareRecipe(): void
    {
        $this->boilWater();
        $this->pourInCup();
        $this->brew();
        $this->addCondiments();
    }

    /**
     * 烧水
     */
    public function boilWater(): void
    {
        dump('boil water...');
    }

    /*
     * 倒进杯子里
     */
    public function pourInCup(): void
    {
        dump('pour in cup...');
    }

    /**
     * 沏茶
     */
    public function brew(): void
    {
        dump("brew...");
    }

    /**
     * 增加调味品
     */
    public function addCondiments(): void
    {
        dump('add condiments...');
    }
}

/**
 * 咖啡类 - 继承咖啡因饮料，重写部分方法
 * Class Coffee
 */
class Coffee extends CaffeineBeverage
{
    public function brew(): void
    {
        dump('Coffee brew...');
    }

    public function addCondiments(): void
    {
        dump('Coffee add Sugar...');
    }
}

/**
 * 茶类 - 继承咖啡因饮料，重写部分方法
 * Class Tea
 */
class Tea extends CaffeineBeverage
{
    public function brew(): void
    {
        dump('Tea brew...');
    }

    public function addCondiments(): void
    {
        dump('add air...');
    }
}
