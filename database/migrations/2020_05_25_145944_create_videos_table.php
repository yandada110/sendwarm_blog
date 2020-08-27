<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Collect\Video\Video;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Video::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('video_title')->comment('视频标题');
            $table->text('video_describe')->comment('视频描述');
            $table->string('video_img')->comment('视频封面');
            $table->string('video_link')->nullable()->comment('视频路径');
            $table->integer('video_click')->default(0)->comment('点击量');
            $table->integer('video_sort')->default(100)->comment('视频排序');
            $table->integer('video_recommend')->default(2)->comment('是否推荐【1是0否】');
            $table->tinyInteger('video_show')->default(1)->comment('是否显示【1是0否】');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE ".Video::TABLE." comment '视频列表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Video::TABLE);
    }
}
