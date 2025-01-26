<?php

namespace App\Console\Commands\Calc;

use Illuminate\Console\Command;

class BinaryTree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:binary-tree';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '二叉树';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // 二叉树
        $arr = ['', 'A', 'B', 'C', 'D', 'E', 'F', 'G'];

        // 下标2*i是左子节点，2*i+1是右子节点

        // 二叉树的前序遍历
//        $this->preOrder($arr, 1);

        // 二叉树的中序遍历
//        $this->inOrder($arr, 1);

        // 二叉树的后序遍历
        $this->postOrder($arr, 1);
    }


    /**
     * 前序遍历
     * 对于树中的任意节点来说，先打印这个节点，然后再打印它的左子树，最后打印它的右子树。
     *
     * @param $arr
     * @param $i
     */
    private function preOrder($arr, $i)
    {
        if ($i >= count($arr)) {
            return;
        }

        echo $arr[$i];

        $this->preOrder($arr, 2 * $i);
        $this->preOrder($arr, 2 * $i + 1);
    }

    /**
     * 中序遍历
     * 对于树中的任意节点来说，先打印它的左子树，然后再打印这个节点，最后打印它的右子树。
     */
    private function inOrder($arr, $i)
    {
        if ($i >= count($arr)) {
            return;
        }

        $this->inOrder($arr, 2 * $i);
        echo $arr[$i];
        $this->inOrder($arr, 2 * $i + 1);
    }

    /**
     * 后序遍历
     * 对于树中的任意节点来说，先打印它的左子树，然后再打印它的右子树，最后打印这个节点。
     */
    private function postOrder($arr, $i)
    {
        if ($i >= count($arr)) {
            return;
        }

        $this->postOrder($arr, 2 * $i);
        $this->postOrder($arr, 2 * $i + 1);
        echo $arr[$i];
    }
}
