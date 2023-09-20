<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('students', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('adm_form_id');
            $table->string('adm_no',20);
            $table->date('adm_date');
            $table->integer('std_type_id');
            $table->integer('course_id')->nullable();
            $table->string('loc_cat',10);
            $table->integer('cat_id');
            $table->integer('resvcat_id');
            $table->string('religion',20);
            $table->string('geo_cat',10);
            $table->string('nationality',30);
            $table->string('name',50);
            $table->string('gender',10);
            $table->string('father_name',50);
            $table->string('mother_name',50);
            $table->string('guardian_name',50)->nullable();
            $table->date('dob')->nullable();
            $table->string('phone',20)->nullable();
            $table->string('mobile',15)->nullable();
            $table->string('blood_grp',3)->nullable();
            $table->char('migration',1)->default('N');
            $table->char('blind',1)->default('N');
            $table->string('per_address',200)->nullable();
            $table->string('pincode',20)->nullable();
            $table->string('father_occup',50)->nullable();
            $table->string('father_desig',50)->nullable();
            $table->string('father_phone',10)->nullable();
            $table->string('father_mobile',10)->nullable();
            $table->string('f_office_addr',200)->nullable();
            $table->string('father_email',30)->nullable();
            $table->string('mother_occup',50)->nullable();
            $table->string('mother_desig',50)->nullable();
            $table->string('mother_phone',10)->nullable();
            $table->string('mother_mobile',10)->nullable();
            $table->string('mother_email',30)->nullable();
            $table->string('m_office_addr',200)->nullable();
            $table->string('guardian_occup',50)->nullable();
            $table->string('guardian_desig',50)->nullable();
            $table->string('guardian_phone',10)->nullable();
            $table->string('guardian_mobile',10)->nullable();
            $table->string('guardian_email',30)->nullable();
            $table->string('g_office_addr',200)->nullable();
            $table->decimal('annual_income',10,2)->nullable();
            $table->string('pu_regno',20)->nullable();
            $table->string('pupin_no',20)->nullable();
            $table->string('course_code',10)->nullable();
            $table->integer('academic_id')->nullable();
            $table->string('gap_year',10)->nullable();
            $table->char('org_migrate',1)->default('N');
            $table->string('migrate_detail',200)->nullable();
            $table->string('disqualify_detail',200)->nullable();
            $table->string('spl_achieve',20)->nullable();
            $table->string('f_nationality',50)->nullable();
            $table->string('passportno',50)->nullable();
            $table->string('visa',50)->nullable();
            $table->string('res_permit',50)->nullable();
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
        Schema::connection('mysql_yr')->dropIfExists('students');
    }
}
