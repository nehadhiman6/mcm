<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporaryStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_staff', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id');
            $table->integer('desig_id')->nullable();
            $table->date('mcm_joining_date')->nullable();
            $table->date('left_date')->nullable();
            $table->string('left_status',200)->nullable();
            $table->string('remarks',500)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::table('staff', function (Blueprint $table) {
            if (Schema::hasColumn('staff', 'left_date') == false) {
                $table->date('left_date')->after('mcm_joining_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temporary_staff');

    }
}
