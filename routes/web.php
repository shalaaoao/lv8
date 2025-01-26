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
            33, 16, 50, 13, 18, 34, 58, 15, 17, 25, 51, 66, 19, 27, 55
        ];

        $arr = [55, 54, 100];

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
});
