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
//        for ($i =0;$i<10;$i++){
//            run(function ($i) {
//                echo $i;
//            });
//        }



        \Co\run(function() {
            $a = go(function () {
            Coroutine::sleep(1);
//                sleep(1);
                dump(111);
                dump(111);
                dump(111);
                dump(111);
                dump(111);
                dump(111);
                dump(111);
                dump(111);
            });

            $a = go(function () {
                dump(222);
            });

            dump(3333);
        });


        dump('aaaaaaa');
    }
}
