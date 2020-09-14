<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use \App\Models\Notes\Tag;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Tag::TABLE, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("tag_name",20)->comment("名称");
            $table->boolean('tag_status')->default(true)->comment('标签状态0：关闭；1：显示');
            $table->integer('tag_click')->default(0)->comment('点击量');
            $table->unsignedInteger("tag_sort")->default(0)->comment("排序");
            $table->timestamps();
        });
        DB::statement("ALTER TABLE ".Tag::TABLE." comment '标签表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Tag::TABLE);
    }
}
