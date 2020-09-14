<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use \App\Models\Notes\TagGable;

class CreateTagGablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TagGable::TABLE, function (Blueprint $table) {
            $table->unsignedInteger('tag_id');
            $table->unsignedInteger("sw_tag_gables_id");
            $table->string("sw_tag_gables_type",50);
        });
        DB::statement("ALTER TABLE ".TagGable::TABLE." comment '标签中间表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(TagGable::TABLE);
    }
}
