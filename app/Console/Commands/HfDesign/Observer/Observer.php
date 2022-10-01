<?php

namespace App\Console\Commands\HfDesign\Observer;

use Illuminate\Console\Command;

class Observer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:observer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 观察者模式';

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
        $weatherSubject = new WeatherSubject();
        $observer1      = new Panel1();
        $observer2      = new Panel2();

        // 添加观察者
        $weatherSubject->registerObserver($observer1);
        $weatherSubject->registerObserver($observer2);

        // 设置天气内容
        $weatherEntity = new WeatherEntity();
        $weatherEntity->setTemperature(30);
        $weatherEntity->setHumidity(70);
        $weatherEntity->setPressure(90);

        // 通知
        $weatherSubject->notifyObserver($weatherEntity);

        // 删除观察者1
        $weatherSubject->removeObserver($observer2);

        // 设置天气内容
        $weatherEntity = new WeatherEntity();
        $weatherEntity->setTemperature(100);
        $weatherEntity->setHumidity(200);
        $weatherEntity->setPressure(300);

        // 通知
        $weatherSubject->notifyObserver($weatherEntity);
    }
}

interface ISubject
{
    public function registerObserver(IObserver $observer);

    public function removeObserver(IObserver $observer);

    public function notifyObserver(WeatherEntity $weatherEntity);
}

class WeatherSubject implements ISubject
{
    private array $observerLists;

    public function registerObserver(IObserver $observer)
    {
        $this->observerLists[] = $observer;
    }

    public function removeObserver(IObserver $observer)
    {
        foreach ($this->observerLists as $k => $obs) {
            if ($obs == $observer) {
                unset($this->observerLists[$k]);
                break;
            }
        }
    }

    public function notifyObserver(WeatherEntity $weatherEntity)
    {
        foreach ($this->observerLists as $observer) {
            $observer->update($weatherEntity)
                     ->display();
        }
    }
}

abstract class IObserver
{
    protected WeatherEntity $weatherEntity;

    public function update(WeatherEntity $weatherEntity): self
    {
        $this->weatherEntity = $weatherEntity;
        return $this;
    }

    abstract protected function display();
}


class Panel1 extends IObserver
{
    public function display()
    {
        dump("Pannel1 只显示温度:" . $this->weatherEntity->getTemperature());
    }
}

class Panel2 extends IObserver
{
    public function display()
    {
        dump("Pannel2 只显示湿度:" . $this->weatherEntity->getHumidity());
    }
}

class WeatherEntity
{
    /**
     * 温度
     * @var int
     */
    private int $temperature;

    /**
     * 湿度
     * @var int
     */
    private int $humidity;

    /**
     * 气压
     * @var int
     */
    private int $pressure;


    /**
     * @return int
     */
    public function getTemperature(): int
    {
        return $this->temperature;
    }

    /**
     * @param int $temperature
     */
    public function setTemperature(int $temperature): void
    {
        $this->temperature = $temperature;
    }

    /**
     * @return int
     */
    public function getHumidity(): int
    {
        return $this->humidity;
    }

    /**
     * @param int $humidity
     */
    public function setHumidity(int $humidity): void
    {
        $this->humidity = $humidity;
    }

    /**
     * @return int
     */
    public function getPressure(): int
    {
        return $this->pressure;
    }

    /**
     * @param int $pressure
     */
    public function setPressure(int $pressure): void
    {
        $this->pressure = $pressure;
    }

}
