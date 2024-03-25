<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePtCrawlerLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pt_crawler_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pt_crawler_id')->default(0)->comment('爬虫任务id');
            $table->string('request', 255)->default('')->comment('请求');
            $table->string('match_result', 1024)->nullable()->comment('匹配到的结果');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pt_crawler_logs');
    }
}
