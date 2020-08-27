<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use  App\Models\Collect\Music\SongList;

class CreateSongListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(SongList::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('song_list_title',100)->comment('歌单标题');
            $table->text('song_list_describe')->comment('歌单描述');
            $table->string('song_list_img',100)->comment('歌单封面');
            $table->integer('song_list_click')->default(0)->comment('点击量');
            $table->tinyInteger('song_list_show')->default(1)->comment('是否显示【1是0否】');
            $table->integer('song_list_sort')->default(100)->comment('歌单排序');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE ".SongList::TABLE." comment '歌单'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(SongList::TABLE);
    }
}
