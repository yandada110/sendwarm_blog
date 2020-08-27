<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use  App\Models\Collect\Photo\Photo;
use Illuminate\Support\Facades\DB;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Photo::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('photo_title',100)->comment('相册标题');
            $table->text('photo_describe')->comment('相册描述');
            $table->string('photo_img',120)->nullable(true)->comment('相册封面');
            $table->text('photo_json')->nullable(true)->comment('照片json');
            $table->integer('photo_click')->default(0)->comment('点击量');
            $table->tinyInteger('photo_show')->default(1)->comment('是否显示【1是0否】');
            $table->integer('photo_sort')->default(100)->comment('相册排序');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE ".Photo::TABLE." comment '相册图片'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Photo::TABLE);
    }
}
