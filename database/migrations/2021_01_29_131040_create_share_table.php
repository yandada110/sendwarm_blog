<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Share\Share;

class CreateShareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Share::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("nav_id")->index("index_nav_id")->comment("导航栏id");
            $table->string('share_title',200)->comment('分享标题');
            $table->string('share_icon',200)->nullable()->comment('分享icon');
            $table->string('share_src',200)->nullable()->comment('分享封面');
            $table->text('share_intro')->nullable()->comment('描述');
            $table->longText('share_describe')->nullable()->comment('内容详情');
            $table->string('share_link',200)->nullable()->comment('访问连接');
            $table->integer('share_sort')->default(0)->comment('排序');
            $table->tinyInteger('share_show')->default(0)->comment('是否显示');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE ".Share::TABLE." comment '分享列表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Share::TABLE);
    }
}
