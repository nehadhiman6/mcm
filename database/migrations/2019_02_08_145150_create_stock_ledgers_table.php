<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_ledger', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('trans_type', 5)->default('');
            $table->integer('trans_id')->default(0);
            $table->integer('trans_det_id')->default(0);
            $table->integer('item_id')->default(0);
            $table->integer('loc_id')->nullable();
            $table->decimal('r_qty', 12, 3)->nullable();
            $table->decimal('i_qty', 12, 3)->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('stock_ledger');
    }
}
