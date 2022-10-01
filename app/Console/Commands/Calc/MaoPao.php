<?php

namespace App\Console\Commands\Calc;

use App\Http\Model\StarLog;
use Illuminate\Console\Command;

class MaoPao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:mao-pao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '算法-冒泡排序';

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
        $arr = [1, 3, 5, 7, 9, 2, 4, 6, 8];
        for ($i = 0; $i < count($arr); $i++) {
            for ($j = 0; $j < count($arr) - $i - 1; $j++) {

                // 从小到大
                if ($arr[$j] > $arr[$j + 1]) {
                    list($arr[$j], $arr[$j + 1]) = [$arr[$j + 1], $arr[$j]];
                }
            }
        }

        print_r($arr);
    }
}
