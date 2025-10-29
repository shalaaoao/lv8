<?php

namespace App\Console\Commands;

use App\Model\StarLog;
use Guanguans\Notify\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Guanguans\Notify\Messages\FeiShu\TextMessage;
use Illuminate\Support\Facades\Redis;

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

    private string $outPath;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $a = Redis::set('a', 1);
        dd(Redis::get('a'));
    }


}
