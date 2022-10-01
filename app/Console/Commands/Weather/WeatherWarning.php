<?php

namespace App\Console\Commands\Weather;

use App\Services\Notices\BaseNotice;
use App\Services\Notices\Weather;
use Illuminate\Console\Command;

class WeatherWarning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:warning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '推送今日、明日天气提醒';

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
        $msg = Weather::instance()->warn();
        BaseNotice::send($msg, ['18621311906']);
    }
}
