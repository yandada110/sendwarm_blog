<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Collect\Music\MusicSong;
use Illuminate\Support\Facades\DB;

class CreateMusicSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MusicSong::TABLE, function (Blueprint $table) {
            $table->unsignedInteger("music_id")->comment("音乐id");
            $table->unsignedInteger("song_id")->comment("歌单id");
        });
        DB::statement("ALTER TABLE ".MusicSong::TABLE." comment '音乐-歌单'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(MusicSong::TABLE);
    }
}
