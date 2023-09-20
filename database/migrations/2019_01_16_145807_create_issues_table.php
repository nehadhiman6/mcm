<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('issue_dt');
            $table->integer('loc_id');
            $table->string('request_no', 15)->default('');
            $table->string('person')->nullable();
            $table->string('remarks', 500)->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('issue_dets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('issue_id');
            $table->integer('item_id');
            $table->decimal('req_qty', 10, 2);
            $table->string('req_for')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('issues');
        Schema::dropIfExists('issue_dets');
    }
}
