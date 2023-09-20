<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDamageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('trans_dt');
            $table->string('remarks', 500);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('damage_dets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('damage_id');
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
        Schema::dropIfExists('damages');
        Schema::dropIfExists('damage_dets');
    }
}
