<?php

namespace App\Console\Commands\Weather;

use App\Services\Notices\BaseNotice;
use App\Services\Notices\Weather;
use Carbon\Carbon;
use Illuminate\Console\Command;

class WeatherEating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:eating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '推送天气吃饭提醒';

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
        if (Carbon::now()->isWeekend()) {
            return;
        }

        $msg = Weather::instance()->eat();
        if ($msg) {
//            dingNotice('php_eat')->setTextMessage('『PHP』'.$msg)->setAtAll()->send();
//            BaseNotice::send($msg, ['18621311906']);
        }
    }
}
