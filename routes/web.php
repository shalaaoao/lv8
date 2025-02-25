<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pwd', function () {
    return view('pwd');
});

Route::prefix('calc')->group(function () {
    Route::get('/binary-tree', function () {

        // 创建树
        $tree = new \App\Entity\Calc\TreeNode(null);

//        $arr = range(1, 100);
//        shuffle($arr);

        $arr = [
            33,
            16,
            50,
            13,
            18,
            34,
            58,
            15,
            17,
            25,
            51,
            66,
            19,
            27,
            55
        ];

        foreach ($arr as $i) {
            $tree->insert($tree, $i, ['uuid' => \Illuminate\Support\Str::uuid()->jsonSerialize() . '-' . $i]);
        }

        // 删除元素55（没有子节点）
        $tree->deleteFirst(55);

        // 删除元素13（有一个子节点）
//        $tree->deleteFirst(13);
//
//        // 删除元素18（有两个子节点）
//        $tree->deleteFirst(18);
////        $tree->deleteFirst(16);
////        $a = $tree->findAll(16);
////        dd($a);
//
//        $tree->deleteAll(50);


        $html = $tree->generateTreeHtml($tree);

//        $tree->inOrder($tree, true);

        return view('calc/binary-tree', ['tree' => $html]);
    });

    Route::get('/heap-tree', function () {

        ini_set('memory_limit', '1030M');

//        $heap = new \App\Entity\Calc\Heap('max');
//
//        $arr = range(1, 20);
//        shuffle($arr);
////        $arr = [8,5,3,4,2,9,10,6,1,7];
//
////        dump(implode(',', $arr));
//
//        foreach ($arr as $i) {
//            $heap->insert($i);
//        }
//
////        $heap->insert(13);
////        $heap->insert(2);
////        $heap->insert(11);
//
//        $heap->deleteTop();

        // 已有数组建堆
        $arr = range(1, 10);
        shuffle($arr);

        $heap2       = new \App\Entity\Calc\Heap('max');
        $heap2->heap = $heap2->buildHeap($arr);
//
        $html = $heap2->generateHeapHtml();

        return view('calc/binary-tree', ['tree' => $html]);
    });

    // 五子棋
    Route::get('five-in-five', function () {

        // 初始化15*15的二维数组
        $arr = [];
        for ($i = 0; $i < 15; $i++) {
            for ($j = 0; $j < 15; $j++) {
                $arr[$i][$j] = 0;
            }
        }

        // 黑子代表1·，白字代表2
        $arr[0][0] = 1;
        $arr[1][1] = 2;
        $arr[2][2] = 1;
        $arr[3][3] = 2;

        return view('calc/five-in-five', ['arr' => $arr]);
    });
});
