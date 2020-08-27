<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Website\Nav;
use Illuminate\Support\Facades\DB;

class CreateNavsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Nav::TABLE, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nav_title',150)->comment('导航名称');
            $table->integer('nav_type')->default(0)->comment('导航类型【1文章2照片3音乐4视频】');
            $table->tinyInteger('nav_open')->default(true)->comment('导航是否启用【1启用0关闭】');
            $table->integer('nav_sort')->default(100)->comment('导航排序');
            $table->integer('nav_pid')->default(0)->comment('导航上级id');
            $table->tinyInteger('is_nav')->default(true)->comment('路由启用nav_id');
            $table->string('nav_route',100)->nullable(true)->comment('导航前端路由');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE ".Nav::TABLE." comment '导航表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Nav::TABLE);
    }
}
