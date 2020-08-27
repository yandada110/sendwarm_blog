<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Collect\Music\Music;
use Illuminate\Support\Facades\DB;

class CreateMusicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Music::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('music_name',100)->comment('音乐名称');
            $table->text('music_describe')->comment('音乐描述');
            $table->string('music_img',100)->comment('音乐封面图');
            $table->string('music_url',150)->default('')->comment('音乐地址');
            $table->integer('article_click')->default(0)->comment('点击量');
            $table->tinyInteger('music_show')->default(1)->comment('是否显示【1是0否】');
            $table->tinyInteger('music_play')->default(1)->comment('添加播放列表【1是0否】');
            $table->integer('music_sort')->default(100)->comment('音乐排序');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE ".Music::TABLE." comment '音乐'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Music::TABLE);
    }
}
