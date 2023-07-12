<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Swoole\Coroutine;
use function Swoole\Coroutine\run;
use function Swoole\Coroutine\go;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test1';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $client = new \Helloworld\GreeterClient('localhost:50051', [
            'credentials' => \Grpc\ChannelCredentials::createInsecure(),
        ]);

        $request = new \Helloworld\HelloRequest();
        $request->setName('World');

        $response = $client->SayHello($request)->wait();

        echo $response[0]->getMessage();

    }
}
