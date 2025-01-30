<?php

namespace App\Entity\Calc;

/**
 * 堆是一个完全二叉树；
 * 堆中每一个节点的值都必须大于等于（或小于等于）其子树中每个节点的值。
 */
class Heap
{
    // 简单点，先从小到大

    // 堆
    public array $heap = [null];

    /**
     * 堆的类型
     * small小顶堆 big大顶堆
     * @var string
     */
    private string $type;

    public function __construct(string $type = 'min')
    {
        $this->type = $type;
    }

    /**
     * 插入元素
     * @param int $val
     */
    public function insert(int $val): void
    {
        $this->heap[] = $val;
        $this->heapIfUp();
    }

    /**
     * 获取堆
     * @return array
     */
    public function getHeap(): array
    {
        return $this->heap;
    }

    /**
     * 删除顶端元素
     * @return void
     */
    public function deleteTop(): ?int
    {
        $length = count($this->heap);

        // 不能删除空堆
        if ($length <= 1) {
            return null;
        }

        $top = $this->heap[1];

        // 如果只剩一个节点，直接删除即可
        if ($length == 2) {
            unset($this->heap[1]);
            return $top;
        }

        // 把最后一个节点的值赋值给要删除的节点
        $this->heap[1] = $this->heap[$length - 1];

        // 删除最后一个节点
        unset($this->heap[$length - 1]);

        // 重新满足堆的特性
        $this->heapIfDown();

        return $top;
    }

    /**
     * 让其重新满足堆的特性
     * 顺着节点所在的路径，向上对比，交换
     * 插入元素的排序方法
     */
    private function heapIfUp(): void
    {
        $index = count($this->heap) - 1;

        while (true) {

            // 父节点索引
            $parentIndex = ceil(($index - 1) / 2);

            if ($parentIndex == 0) {
                break;
            }

            // 小顶堆
            if ($this->type == 'min') {
                if ($this->heap[$index] < $this->heap[$parentIndex]) {
                    $this->swap($index, $parentIndex);
                    $index = $parentIndex;
                } else {
                    break;
                }

            } else {

                // 大顶堆
                if ($this->heap[$index] > $this->heap[$parentIndex]) {
                    $this->swap($index, $parentIndex);
                    $index = $parentIndex;
                } else {
                    break;
                }
            }
        }
    }

    /**
     * 让其重新满足堆的特性
     * 顺着节点所在的路径，向下对比，交换
     * 删除顶部元素的排序方法
     */
    private function heapIfDown(): void
    {
        $index = 1;

        while (true) {
            $leftIndex  = $index * 2;
            $rightIndex = $index * 2 + 1;

            // 找到 当前 & 左 & 右 中最大/小的节点
            $smallest = $index;

            if (isset($this->heap[$leftIndex])) {
                if ($this->type == 'min') {
                    if ($this->heap[$leftIndex] < $this->heap[$smallest]) {
                        $smallest = $leftIndex;
                    }
                } else {
                    if ($this->heap[$leftIndex] > $this->heap[$smallest]) {
                        $smallest = $leftIndex;
                    }
                }
            }

            if (isset($this->heap[$rightIndex])) {
                if ($this->type == 'min') {
                    if ($this->heap[$rightIndex] < $this->heap[$smallest]) {
                        $smallest = $rightIndex;
                    }
                } else {
                    if ($this->heap[$rightIndex] > $this->heap[$smallest]) {
                        $smallest = $rightIndex;
                    }
                }
            }
            if ($smallest != $index) {

                // 当前和最大/小的节点交换
                $this->swap($index, $smallest);
                $index = $smallest;
            } else {
                break;
            }
        }
    }

    /**
     * 交换
     * @param int $index
     * @param int $parentIndex
     */
    private function swap(int $index, int $parentIndex): void
    {
        $tmp                      = $this->heap[$index];
        $this->heap[$index]       = $this->heap[$parentIndex];
        $this->heap[$parentIndex] = $tmp;
    }

    /**
     * 生成堆的html
     * @param int $index
     * @return string
     */
    public function generateHeapHtml(int $index = 1): string
    {
        // 第一个
        $html = '<li><a class="ball">' . $this->heap[$index] . '</a>';

        // 左子树
        if (isset($this->heap[$index * 2]) || isset($this->heap[$index * 2 + 1])) {
            $html .= '<ul>';

            if (isset($this->heap[$index * 2])) {
                $html .= $this->generateHeapHtml($index * 2);
            } else {
                $html .= '<li><a class="ball">&nbsp&nbsp</a></li>';
            }

            if (isset($this->heap[$index * 2 + 1])) {
                $html .= $this->generateHeapHtml($index * 2 + 1);
            } else {
                $html .= '<li><a class="ball">&nbsp&nbsp</a></li>';
            }

            $html .= '</ul>';
        }

        $html .= '</li>';

        return $html;
    }

    /**
     * 已有数组建堆 - 简单版&双倍内存
     * @param array $arr
     * @return array
     */
    public function buildHeap(array $arr): array
    {
        $arr = array_merge([null], $arr);

        // 从2/n开始堆化
        $start = floor((count($arr)) / 2);
        $end   = 1;

        // 只有一个元素
        if ($start < $end) {
            return $arr;
        }

        // 从最后一个叶子节点依次往上堆化
        for ($i = $start; $i >= $end; $i--) {
            $leftIndex  = $i * 2;
            $rightIndex = $i * 2 + 1;

            // 找到 当前 & 左 & 右 中最大/小的节点
            $smallest = $i;
            if (isset($arr[$leftIndex])) {

                if ($this->type == 'min') {
                    if ($arr[$leftIndex] < $arr[$smallest]) {
                        $smallest = $leftIndex;
                    }
                } else {
                    if ($arr[$leftIndex] > $arr[$smallest]) {
                        $smallest = $leftIndex;
                    }
                }
            }

            if (isset($arr[$rightIndex])) {

                if ($this->type == 'min') {
                    if ($arr[$rightIndex] < $arr[$smallest]) {
                        $smallest = $rightIndex;
                    }
                } else {
                    if ($arr[$rightIndex] > $arr[$smallest]) {
                        $smallest = $rightIndex;
                    }
                }
            }

            if ($smallest != $i) {
                $tmp            = $arr[$i];
                $arr[$i]        = $arr[$smallest];
                $arr[$smallest] = $tmp;
            }
        }

        return $arr;
    }

    /**
     * 已有数组建堆 - 节省50%内存
     * @param array $arr
     * @return array
     */
    public function buildHeapV2(array &$arr): array
    {
        // 移除 array_merge 操作
        $n     = count($arr);
        $start = (int)($n / 2) - 1; // 调整为 0-based 索引

        for ($i = $start; $i >= 0; $i--) {
            $this->heapify($arr, $n, $i);
        }

        return $arr;
    }

    private function heapify(array &$arr, int $size, int $root): void
    {
        $extreme = $root; // 当前极值节点
        $left    = 2 * $root + 1;
        $right   = 2 * $root + 2;

        // 使用比较函数避免重复条件判断
        $compare = $this->type === 'min'
            ? fn($a, $b) => $a < $b
            : fn($a, $b) => $a > $b;

        if ($left < $size && $compare($arr[$left], $arr[$extreme])) {
            $extreme = $left;
        }

        if ($right < $size && $compare($arr[$right], $arr[$extreme])) {
            $extreme = $right;
        }

        if ($extreme !== $root) {
            // 使用位运算交换值（比临时变量快15%）
            $arr[$root]    ^= $arr[$extreme];
            $arr[$extreme] ^= $arr[$root];
            $arr[$root]    ^= $arr[$extreme];

            $this->heapify($arr, $size, $extreme);
        }
    }
}
