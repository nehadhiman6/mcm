<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pur_return', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('vendor_id');
            $table->string('bill_no')->default();
            $table->date('bill_dt');
            $table->date('trans_dt');
            $table->integer('trans_id');
            $table->integer('total_amount')->default();
            $table->char('trans_type', 1)->default('N');
            $table->string('remarks', 500);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('pur_return_det', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('pur_ret_id');
            $table->integer('item_id');
            $table->integer('pur_id');
            $table->integer('rate')->nullable();
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
        Schema::dropIfExists('pur_return');
        Schema::dropIfExists('pur_return_det');
    }
}
