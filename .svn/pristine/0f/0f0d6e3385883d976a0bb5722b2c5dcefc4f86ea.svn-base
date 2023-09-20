<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('trans_dt');
            $table->integer('department_id');
            $table->string('remarks', 500);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('return_dets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ret_id');
            $table->integer('item_id');
            $table->string('item_desc', 200)->nullable();
            $table->decimal('qty', 10);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returns');
        Schema::dropIfExists('return_dets');
    }
}
