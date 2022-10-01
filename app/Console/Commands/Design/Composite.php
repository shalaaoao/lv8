<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Composite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:composite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-组合模式';

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
        // root用户
        $root = new RoleManger('网站用户');
        $root->add(new Team('主站用户'));
        $root->SendMessage();

        // 社交版块
        $root2    = new RoleManger('社交版块');
        $managerA = new RoleManger('论坛用户');
        $managerA->add(new Team('北京论坛用户'));
        $managerA->add(new Team('上海论坛用户'));

        $managerB = new RoleManger('sns用户');
        $managerB->add(new Team('北京sns用户'));
        $managerB->add(new Team('上海sns用户'));

        $root2->add($managerA);
        $root2->add($managerB);
        $root2->SendMessage();
    }
}

abstract class ARole
{
    protected $userRoleList;
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    abstract public function Add(ARole $role);

    abstract public function Remove(ARole $role);

    abstract public function SendMessage();
}

class RoleManger extends ARole
{
    public function Add(ARole $role)
    {
        $this->userRoleList[] = $role;
    }

    public function Remove(ARole $role)
    {
        $position = 0;
        foreach ($this->userRoleList as $n) {
            ++$position;
            if ($n == $role) {
                array_splice($this->userRoleList, ($position), 1);
            }
        }
    }

    public function SendMessage()
    {
        echo "开始发送用户角色：" . $this->name . '下的所有用户短信', PHP_EOL;
        foreach ($this->userRoleList as $role) {
            $role->SendMessage();
        }
    }
}

class Team extends ARole
{

    public function Add(ARole $role)
    {
        echo "小组用户不能添加下级了！", PHP_EOL;
    }

    public function Remove(ARole $role)
    {
        echo "小组用户没有下级可以删除！", PHP_EOL;
    }

    public function SendMessage()
    {
        echo "小组用户角色：" . $this->name . '的短信已发送！', PHP_EOL;
    }
}
