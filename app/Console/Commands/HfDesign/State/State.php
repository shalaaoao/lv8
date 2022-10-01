<?php

namespace App\Console\Commands\HfDesign\State;

use Illuminate\Console\Command;

class State extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:state';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 状态模式';

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
        $machine = new GumballMachine(1);
        $machine->insertCoin();
        $machine->turnCrank();
        $machine->dispense();
        $machine->insertCoin();
    }
}

/**
 * 状态
 * Class IState
 * @package App\Console\Commands\HfDesign\State
 */
abstract class IState
{
    protected GumballMachine $machine;

    public function __construct(GumballMachine $machine)
    {
        $this->machine = $machine;
    }

    /**
     * 投入硬币
     * @return mixed
     */
    abstract protected function insertCoin();

    /**
     * 弹出硬币
     * @return mixed
     */
    abstract protected function popCoin();

    /**
     * 转动扳机
     * @return mixed
     */
    abstract protected function turnCrank();

    /**
     * 发放奖励
     * @return mixed
     */
    abstract protected function dispense();
}

/**
 * 扭蛋机类
 * Class GumballMachine
 * @package App\Console\Commands\HfDesign\State
 */
class GumballMachine
{
    /**
     * 售罄状态
     * @var IState
     */
    private IState $soldOutState;

    /**
     * 没有硬币状态
     * @var IState
     */
    private IState $noCoinState;

    /**
     * 有硬币状态
     * @var IState
     */
    private IState $hasCoinState;

    /**
     * 正常售卖状态
     * @var IState
     */
    private IState $soldState;

    /**
     * @return IState
     */
    public function getSoldOutState(): IState
    {
        return $this->soldOutState;
    }

    /**
     * @return IState
     */
    public function getNoCoinState(): IState
    {
        return $this->noCoinState;
    }

    /**
     * @return IState
     */
    public function getHasCoinState(): IState
    {
        return $this->hasCoinState;
    }

    /**
     * @return IState
     */
    public function getSoldState(): IState
    {
        return $this->soldState;
    }

    /**
     * 当前状态
     * @var IState
     */
    private IState $currentState;

    /**
     * 球的库存
     * @var int
     */
    private int $count;

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    public function __construct(int $numberGumballs)
    {
        $this->soldOutState = new SoldOutState($this);
        $this->noCoinState  = new NoCoinState($this);
        $this->hasCoinState = new HasCoinState($this);
        $this->soldState    = new SoldState($this);
        $this->count        = $numberGumballs;

        if ($this->count > 0) {

            // 球有库存
            $this->currentState = $this->noCoinState;
        } else {

            // 球售罄
            $this->currentState = $this->soldOutState;
        }
    }

    public function insertCoin(): void
    {
        $this->currentState->insertCoin();
    }

    public function popCoin(): void
    {
        $this->currentState->popCoin();
    }

    public function turnCrank(): void
    {
        $this->currentState->turnCrank();
    }

    public function dispense(): void
    {
        $this->currentState->dispense();
    }

    public function setState(IState $state): void
    {
        $this->currentState = $state;
    }

    public function releaseBall()
    {
        dump("A gumball comes rolling out the slot...");
        if ($this->count != 0) {
            $this->count--;
        }
    }
}

/**
 * 售罄状态
 * Class SoldOutState
 * @package App\Console\Commands\HfDesign\State
 */
class SoldOutState extends IState
{
    public function insertCoin()
    {
        dump('SoldOut reject insertCoin...');
    }

    public function popCoin()
    {
        dump('SoldOut reject popCoin...');
    }

    public function turnCrank()
    {
        dump('SoldOut reject turnCrank...');
    }

    public function dispense()
    {
        dump('SoldOut reject dispense...');
    }
}

/**
 * 没有硬币状态
 * Class NoCoinState
 * @package App\Console\Commands\HfDesign\State
 */
class NoCoinState extends IState
{
    public function insertCoin()
    {
        dump(__CLASS__ . ' insertCoin...');
        $this->machine->setState($this->machine->getHasCoinState());
    }

    public function popCoin()
    {
        dump(__CLASS__ . ' NO COIN TO popCoin!');
    }

    public function turnCrank()
    {
        dump(__CLASS__ . ' NO COIN TO turnCrank!');
    }

    public function dispense()
    {
        dump(__CLASS__ . ' NO COIN TO dispense!');
    }
}

/**
 * 有硬币的状态
 * Class HasCoinState
 * @package App\Console\Commands\HfDesign\State
 */
class HasCoinState extends IState
{
    public function insertCoin()
    {
        dump(__CLASS__ . " don't do insertCoin...");
    }

    public function popCoin()
    {
        dump(__CLASS__ . " popCoin...");
        $this->machine->setState($this->machine->getNoCoinState());
    }

    public function turnCrank()
    {
        dump(__CLASS__ . " do do do turnCrank...");
        $this->machine->setState($this->machine->getSoldState());
    }

    public function dispense()
    {
        dump(__CLASS__ . " don't do dispense...");
    }
}

/**
 * 可出球状态
 * Class SoldState
 * @package App\Console\Commands\HfDesign\State
 */
class SoldState extends IState
{
    public function insertCoin()
    {
        dump(__CLASS__ . " don't to insertCoin");
    }

    public function popCoin()
    {
        dump(__CLASS__ . " don't to popCoin");
    }

    public function turnCrank()
    {
        dump(__CLASS__ . " don't to turnCrank");
    }

    public function dispense()
    {
        dump(__CLASS__ . " dispense");

        // 释放一个球
        $this->machine->releaseBall();

        if ($this->machine->getCount() > 0) {
            dump('dispense success~');

            // 有球库存的情况下
            $this->machine->setState($this->machine->getNoCoinState());
        } else {

            // 球无库存
            dump('Oops, out of gumballs...');
            $this->machine->setState($this->machine->getSoldOutState());
        }
    }
}
