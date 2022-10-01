<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class Template extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-模板模式';

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
        $m = new MemcachedCache();
        $r = new RedisCache();
    }
}

abstract class Cache
{
    private string $config;
    private int    $conn;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->getConfig();
        $this->openConnection();
        $this->checkConnection();
    }

    abstract public function getConfig();

    abstract public function openConnection();

    abstract public function checkConnection();
}

class MemcachedCache extends Cache
{
    public function getConfig()
    {
        echo '获取Memcache配置文件！', PHP_EOL;
        $this->config = 'memcached';
    }

    public function openConnection()
    {
        echo '连接memcached！', PHP_EOL;
        $this->conn = 1;
    }

    public function checkConnection()
    {
        if ($this->conn) {
            echo 'Memcached连接成功！', PHP_EOL;
        } else {
            echo 'Memcached连接失败，请检查配置项！', PHP_EOL;
        }
    }
}

class RedisCache extends Cache
{
    // TODO 省略具体配置

    public function getConfig()
    {
        // TODO: Implement getConfig() method.
    }

    public function openConnection()
    {
        // TODO: Implement openConnection() method.
    }

    public function checkConnection()
    {
        // TODO: Implement checkConnection() method.
    }
}
