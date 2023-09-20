<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name',100);
            $table->string('master_type',50);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('orgnization', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name',100);
            $table->char('external_agency',1)->default('N');
            $table->integer('agency_type_id');
            $table->integer('dept_id')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('org_agency_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('act_type_id');
            $table->string('topic',500)->nullable();
            $table->string('guest_name',50)->nullable();
            $table->string('guest_designation',50)->nullable();
            $table->string('guest_affiliation',100)->nullable();
            $table->string('sponsor_by',100)->nullable();
            $table->string('sponsor_address',200)->nullable();
            $table->integer('college_teachers');
            $table->integer('college_students');
            $table->integer('college_nonteaching');
            $table->integer('outsider_teachers');
            $table->integer('outsider_students');
            $table->integer('outsider_nonteaching');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_collaboration', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('act_id');
            $table->integer('agency_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('master_types');
        Schema::dropIfExists('orgnization');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('activity_collaboration');
    }
}
