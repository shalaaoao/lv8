<?php

namespace App\Console\Commands\HfDesign\Cmd;

use Illuminate\Console\Command;

class Cmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hfdesign:cmd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Head First 命令模式';

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
        $remote = new SimpleRemoteControl();

        // 遥控器开灯
        $remote->setCommand(new LightOnCommand(new Light()))->button();
    }
}

/**
 * 命令接口
 */
interface ICommand
{
    public function execute(): void;
}

/**
 * 开灯命令
 */
class LightOnCommand implements ICommand
{
    private Light $light;

    public function __construct(Light $light)
    {
        $this->light = $light;
    }

    public function execute(): void
    {
        $this->light->on();
    }
}

/**
 * 灯
 */
class Light
{
    public function on()
    {
        dump("light on...");
    }

    public function off()
    {
        dump("light off...");
    }
}

/**
 * 遥控器
 */
class SimpleRemoteControl
{
    private ICommand $ICommand;

    public function setCommand(ICommand $ICommand): self
    {
        $this->ICommand = $ICommand;
        return $this;
    }

    /**
     * 按下按钮
     */
    public function button()
    {
        $this->ICommand->execute();
    }
}
