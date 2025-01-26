<?php

namespace App\Console\Commands\Calc;

use App\Entity\Calc\TreeNode;
use Illuminate\Console\Command;

class BinarySearchTree extends Command
{
    protected $signature = 'calc:binary-search-tree';

    protected $description = '二叉查找树';

    public function handle()
    {
        // 创建树
        $tree = new TreeNode(null);


        $arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        shuffle($arr);

        foreach ($arr as $i) {
            $tree->insert($tree, $i, ['extra' => ['uuid' => \Illuminate\Support\Str::uuid()->jsonSerialize()]]);
        }

        // 查找val=5的树
//        $node = $tree->find(12);
//        dd($node);

        // 前序遍历
        $this->info("前序遍历");
        $tree->preOrder($tree, true);
        $this->info(implode(',', $tree->orderResult));

        // 中序遍历
        $this->info("中序遍历");
        $tree->inOrder($tree, true);
        $this->info(implode(',', $tree->orderResult));

        // 后序遍历
        $this->info("后序遍历");
        $tree->postOrder($tree, true);
        $this->info(implode(',', $tree->orderResult));

        // 生成树的html
        $this->info("生成树的html");
        $html = $tree->generateTreeHtml($tree);
        $this->info($html);
    }
}
