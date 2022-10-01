<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Observers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:observer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式：观察者模式';

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
        $ob1 = new ConcreteObserver1();
        $ob2 = new ConcreteObserver2();
        $ob3 = new ConcreteObserver3();

        $a = new ConcreteSubject();
        $a->attach($ob1);
        $a->attach($ob2);
        $a->attach($ob3);
        $a->setState('AAA');
        $a->setState('BBB');
        $a->detach($ob1);
        $a->setState('CCC');
    }
}


interface Observer
{
    public function update(Subject $subject): void;
}

class ConcreteObserver1 implements Observer
{
    public function update(Subject $subject): void
    {
        $observerState = $subject->getState();
        echo "执行观察者1操作！当前操作：" . $observerState . PHP_EOL;
    }
}

class ConcreteObserver2 implements Observer
{
    public function update(Subject $subject): void
    {
        $observerState = $subject->getState();
        echo "执行观察者2操作！当前操作：" . $observerState . PHP_EOL;
    }
}

class ConcreteObserver3 implements Observer
{
    public function update(Subject $subject): void
    {
        $observerState = $subject->getState();
        echo "执行观察者3操作！当前操作：" . $observerState . PHP_EOL;
    }
}

class Subject
{
    protected array  $observers = [];
    protected string $stateNow;

    public function attach(Observer $observer): void
    {
        array_push($this->observers, $observer);
    }

    public function detach(Observer $observer): void
    {
        foreach ($this->observers as $k => $ob) {
            if ($ob == $observer) {
                unset($this->observers[$k]);
            }
        }
    }

    public function notify(): void
    {
        foreach ($this->observers as $ob) {
            $ob->update($this);
        }
    }
}

class ConcreteSubject extends Subject
{
    public function setState($state)
    {
        $this->stateNow = $state;
        $this->notify();
    }

    public function getState()
    {
        return $this->stateNow;
    }
}
