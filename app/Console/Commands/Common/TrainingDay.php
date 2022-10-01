<?php

namespace App\Console\Commands\Common;

use App\Services\Notices\BaseNotice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TrainingDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'common:training-day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每日健身';

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

        $msg = "dididi~健身健身啦~🏃🏻‍";

        BaseNotice::send($msg, ['18621311906']);
    }
}
