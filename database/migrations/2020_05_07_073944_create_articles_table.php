<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Notes\Article;
use Illuminate\Support\Facades\DB;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *文章列表
     * @return void
     */
    public function up()
    {
        Schema::create(Article::TABLE, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger("nav_id")->index("index_nav_id")->comment("导航栏id");
            $table->string("article_title",100)->comment("文章标题");
            $table->string("article_image",100)->comment("列表图片");
            $table->text("article_describe")->comment("文章简介");
            $table->longText("article_content")->comment("文章内容");
            $table->integer('article_click')->default(0)->comment('点击量');
            $table->boolean('article_status')->default(1)->comment('文章状态0：未审核，1：通过；2：未通过；3：已删除');
            $table->boolean('article_show')->default(true)->comment('是否显示');
            $table->unsignedInteger("article_sort")->default(0)->comment("排序");
            $table->timestamps();
        });
        DB::statement("ALTER TABLE ".Article::TABLE." comment '文章信息表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Article::TABLE);
    }
}
