<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlumaniTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumni_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile', 15);
            $table->string('password');
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('alumni_students', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('alumni_user_id');
            $table->string('name',50);
            $table->string('gender',10);
            $table->string('father_name',50);
            $table->string('mother_name',50);
            $table->string('passout_year',50);
            $table->date('dob')->nullable();
            $table->string('email',100)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('mobile',15)->nullable();
            $table->string('per_address',200)->nullable();
            $table->char('ugc_qualified')->default('N');
            $table->string('ugc_subject_name')->nullable();
            $table->char('competitive_exam_qualified')->default('N');
            $table->integer('competitive_exam_id')->default(0)->nullable();
            $table->string('other_competitive_exam')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
            

        Schema::create('alumni_stu_qual', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('alumni_stu_id');
            $table->integer('course_id');
            $table->string('subject',1000)->nullable();
            $table->char('mcm_college')->default('Y');
            $table->string('degree_type'); // professional or research or graduate or post graduate
            $table->string('passing_year')->nullable(); 
            $table->string('research_area',1000)->nullable(); 
            $table->string('other_institute')->nullable();
            $table->string('other_course')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('alumni_experience', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('alumni_stu_id',50);
            $table->string('emp_type')->nullable();  // self-Employed/salaried/charity
            $table->string('org_name')->nullable();
            $table->string('area_of_work')->nullable();
            $table->string('org_address')->nullable();
            $table->string('designation')->nullable();
            $table->integer('num_of_employees')->nullable();
            $table->date('start_date')->nullable(); //
            $table->date('end_date')->nullable(); //
            $table->char('currently_working')->default('N'); //
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
        Schema::dropIfExists('alumni_users');
        Schema::dropIfExists('alumni_students');
        Schema::dropIfExists('alumni_stu_qual');
        Schema::dropIfExists('alumni_experience');
    }

}
