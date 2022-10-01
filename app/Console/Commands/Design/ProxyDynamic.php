<?php

namespace App\Console\Commands\Design;

use Illuminate\Console\Command;

class ProxyDynamic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design:proxy-dynamic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设计模式-代理模式-动态代理';

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
        $proxy          = new MetricsCollectorProxy(new MetricsCollector);
        $userController = $proxy->createProxy(new UserController);
        $userController->login(13800138000, 'pwd');
    }
}

interface IUserController
{
    public function login(string $telephone, string $password);

    public function register(string $telephone, string $password);
}

class UserController implements IUserController
{
    public function login(string $telephone, string $password)
    {
        echo 'is Login' . PHP_EOL;
    }

    public function register(string $telephone, string $password)
    {
        echo 'is Register' . PHP_EOL;
    }
}

class MetricsCollector
{
    public function recordRequest(RequestInfo $requestInfo)
    {

    }
}

class RequestInfo
{
    public function __construct(string $apiName, int $responseTime, int $startTimestamp)
    {

    }
}

class MetricsCollectorProxy
{
    private $proxiedObject;

    private $metricsCollector;

    public function __construct(MetricsCollector $metricsCollector)
    {
        $this->metricsCollector = $metricsCollector;
    }

    public function createProxy(object $object)
    {
        $this->proxiedObject = $object;
        return $this;
    }

    public function __call($method, $arguments)
    {
        $ref = new \ReflectionClass($this->proxiedObject);
        if (!$ref->hasMethod($method)) {
            throw new \Exception("method not existed");
        }

        $method         = $ref->getMethod($method);
        $startTimestamp = time();
        $userVo         = $this->callMethod($method, $arguments);
        $endTimeStamp   = time();
        $responseTime   = $endTimeStamp - $startTimestamp;
        $requestInfo    = new RequestInfo("login", $responseTime, $startTimestamp);
        $this->metricsCollector->recordRequest($requestInfo);

        return $userVo;
    }


    private function callMethod(\ReflectionMethod $method, $arguments)
    {
        // 前置判断省略
        $method->invokeArgs($this->proxiedObject, $arguments);
    }

}
