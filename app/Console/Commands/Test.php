<?php

namespace App\Console\Commands;

use App\Model\StarLog;
use Guanguans\Notify\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
         $a = Factory::feiShu()
               ->setToken('fefc8f74-0384-4c34-a7bb-2061e10563ed')
               ->setSecret('qF4XrVgQ1631VYaUPRRtEh')
               ->setMessage((new \Guanguans\Notify\Messages\Feishu\TextMessage('『aoao』teststestsetsetsetset')))
               ->send();

         dd($a);
    }

}
