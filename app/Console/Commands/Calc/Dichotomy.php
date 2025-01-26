<?php

namespace App\Console\Commands\Calc;

use Illuminate\Console\Command;

class Dichotomy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:dichotomy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '算法-二分法';

    private int $startKey = 0;
    private int $endKey   = 0;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arr = [];

        // 生成1000w整数
        for ($i = 0; $i < 1000000; $i++) {
            $arr[] = rand(0, 100000000);
        }

        $num = 200;

        // 把猜的数放进array里，确保有
        $arr[] = $num;

        // 排序
        sort($arr);

        $this->startKey = 0;
        $this->endKey   = count($arr) - 1;

        $this->info("num:" . $num);

        $resultKey = $this->dichotomy($num, $arr);

        $this->info("correctKey:" . $resultKey);
//        $this->info("correctNum:" . $arr[$resultKey]);

        dump(array_splice($arr, 0, 10));
    }

    /**
     * 二分
     * @param int $num
     * @param array $arr
     * @return int|null
     */
    private function dichotomy(int $num, array $arr): ?int
    {
        while ($this->startKey <= $this->endKey) {

            // 本轮key
            $cKey = floor(($this->startKey + $this->endKey) / 2);

            $cNum = $arr[$cKey];

            // 正确直接返回key
            if ($cNum == $num) {
                $this->info("===");
                return $cKey;
            }

            if ($cNum > $num) {
                $this->endKey = $cKey - 1;
                $this->info("> " . $this->startKey . ' - ' . $this->endKey);
            } else {
                $this->startKey = $cKey + 1;
                $this->info("< " . $this->startKey . ' - ' . $this->endKey);
            }
        }

        return null;
    }
}
