<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventryMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('item', 100)->unique();
            $table->integer('it_cat_id')->default(0);
            $table->string('it_sub_cat_id')->default(0);
            $table->string('item_code', 15);
            $table->string('remarks', 200);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('item_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('category', 100)->unique();
            $table->integer('sub_cat_id')->default(0);
            $table->integer('cat_id')->default(0);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('item_sub_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('category', 100)->unique();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('vendors', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('vendor_name', 50);
            $table->string('code', 20)->default('');
            $table->string('mobile', 10);
            $table->integer('city_id');
            $table->string('vendor_address', 200);
            $table->string('contact_no', 10);
            $table->string('contact_person', 50);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('vendor_id');
            $table->string('bill_no')->default();
            $table->date('bill_dt');
            $table->date('trans_dt');
            $table->integer('trans_id');
            $table->char('trans_type', 1)->default('N');
            $table->string('remarks', 500);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('purchase_dets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('pur_id');
            $table->integer('item_id');
            $table->decimal('qty', 10);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('trans_dt');
            $table->integer('department_id');
            $table->string('person')->nullable();
            $table->string('remarks', 500);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('request_dets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('request_id');
            $table->integer('item_id');
            $table->string('req_for', 200)->nullable();
            $table->decimal('req_qty', 10);
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
        Schema::dropIfExists('items');
        Schema::dropIfExists('item_categories');
        Schema::dropIfExists('item_sub_categories');
        Schema::dropIfExists('vendors');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('purchase_dets');
        Schema::dropIfExists('requests');
        Schema::dropIfExists('request_dets');
    }
}
