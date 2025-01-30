<?php

namespace App\Console\Commands\Calc;

use Illuminate\Console\Command;

class Graph extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:graph';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '图';

    public function handle()
    {

        /****************** 使用示例 ******************/
        // 初始化邻接表（根据实际情况调整）
        $adj = [
            [1, 2],    // 节点0的邻居
            [0, 3],    // 节点1的邻居
            [0, 3],    // 节点2的邻居
            [1, 2]     // 节点3的邻居
        ];
        $v   = 4;

        // 创建对象并执行BFS
        $sp = new ShortestPath($v, $adj);
        $sp->bfs(0, 3); // 输出：0 1 3 或 0 2 3（取决于邻接表顺序）

    }
}

class ShortestPath
{
    private array $adj;
    private int $v;

    public function __construct(int $v, array $adj)
    {
        $this->v   = $v;
        $this->adj = $adj;
    }

    public function bfs(int $s, int $t)
    {
        if ($s == $t) {
            return;
        }

        // 初始化访问数组和前置节点数组
        $visited     = array_fill(0, $this->v, false);
        $visited[$s] = true;

        // 使用SplQueue实现队列（比数组效率更高）
        $queue = new \SplQueue();
        $queue->enqueue($s);

        $prev = array_fill(0, $this->v, -1);

        while (!$queue->isEmpty()) {
            $w = $queue->dequeue();

            // 遍历当前节点的所有邻接节点
            foreach ($this->adj[$w] as $q) {
                if (!$visited[$q]) {
                    $prev[$q] = $w;

                    // 找到目标节点，打印路径并返回
                    if ($q == $t) {
                        $this->printPath($prev, $s, $t);
                        echo PHP_EOL; // 换行符根据系统调整
                        return;
                    }

                    $visited[$q] = true;
                    $queue->enqueue($q);
                }
            }
        }
    }

    private function printPath($prev, $s, $t)
    {
        // 递归打印路径（保持与Java相同的顺序）
        if ($prev[$t] != -1 && $t != $s) {
            $this->printPath($prev, $s, $prev[$t]);
        }
        echo $t . " ";
    }
}
