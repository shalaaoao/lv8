<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StarController;
use Swoole\Coroutine;
use function Swoole\Coroutine\go;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('hello', function () {
//    echo phpinfo();

//    Coroutine::set(['max_coroutine' => 3000]);
//    Coroutine::set(['enable_coroutine' => true]);
//    dump(Coroutine::getOptions());

    \Co\run(function() {
        $a = go(function () {
//            Coroutine::sleep(1);
//                sleep(1);
            dump(111);
            dump(111);
            dump(111);
            dump(111);
            dump(111);
            dump(111);
            dump(111);
            dump(111);
        });

        $a = go(function () {
            dump(222);
        });

        dump(3333);
    });



});

Route::any("/tests", "TestController@tests");

Route::group(['prefix' => 'star'], function ($router) {

    // 获取日志
    $router->get('lists', [StarController::class, 'lists']);

    // 新增
    $router->post('add', [StarController::class, 'add']);

    // 新增page
    $router->get('add-page', [StarController::class, 'addPage']);
});

