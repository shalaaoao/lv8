<?php

namespace App\Console\Commands\Common;

use App\Services\Notices\BaseNotice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class WorkLunch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'common:work-lunch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '工作日吃饭提醒';

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

        $msg = "定时吃饭吃饭吃饭";

//        BaseNotice::send('');
    }
}
