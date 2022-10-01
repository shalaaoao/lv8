<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Memento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:memento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-备忘录模式';

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
        $o = new Originator();
        $o->setState('状态1');
        $o->showState();

        // 保存状态
        $c = new Caretaker();
        $c->setMemento($o->createMemento());

        $o->setState('状态2');
        $o->showState();

        // 还原状态
        $o->setBakMemento($c->getMemento());
        $o->showState();
    }
}

class Originator
{
    private string $state;

    /**
     * 读档，并设置
     * @param CMemento $m
     */
    public function setBakMemento(CMemento $m)
    {
        $this->state = $m->getState();
    }

    public function createMemento()
    {
        $m = new CMemento();
        $m->setState($this->state);
        return $m;
    }

    public function setState(string $state)
    {
        $this->state = $state;
    }

    public function showState()
    {
        echo $this->state, PHP_EOL;
    }
}

class CMemento
{
    private string $state;

    public function setState(string $state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }
}

class Caretaker
{
    private CMemento $memento;

    public function setMemento(CMemento $memento)
    {
        $this->memento = $memento;
    }

    public function getMemento()
    {
        return $this->memento;
    }
}
