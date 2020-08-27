<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Website\Notice;
use Illuminate\Support\Facades\DB;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Notice::TABLE, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger("nav_id")->index("index_nav_id")->comment("导航栏模块");
            $table->string('notice_title',100)->comment('公告标题');
            $table->longText('notice_content')->comment('公告内容');
            $table->integer('notice_sort')->default(100)->comment('公告排序');
            $table->tinyInteger('notice_show')->default(1)->comment('是否显示【1是2否】');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE ".Notice::TABLE." comment '告示'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Notice::TABLE);
    }
}
