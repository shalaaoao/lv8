<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePtCrawlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pt_crawler', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('mode', 32)->default('')->comment('adult/tvshow');
            $table->string('keyword', 255)->default('')->comment('搜索的内容');
            $table->string('discount', 32)->default('')->comment('折扣 FREE');
            $table->json('rule')->nullable()->comment('匹配的规则 {"name": "xxx", "smallDescr": "vvvvv"}');
            $table->unsignedInteger('frequency')->default(0)->comment('频率（次/N分钟）');
            $table->tinyInteger('status')->default(0)->comment('0进行中 1已完成 2已停止');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pt_crawler');
    }
}
