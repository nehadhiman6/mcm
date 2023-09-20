<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsIntoHostelFormMigartion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_yr')->table('admission_form_hostel', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'guardian_name') == false) {
                $table->string('guardian_name',50)->after('schedule_backward_tribe');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'guardian_phone') == false) {
                $table->string('guardian_phone',50)->after('guardian_name')->nullable();
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'guardian_mobile') == false) {
                $table->string('guardian_mobile',50)->after('guardian_phone');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'guardian_email') == false) {
                $table->string('guardian_email',50)->after('guardian_mobile')->nullable();
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'guardian_address') == false) {
                $table->string('guardian_address',500)->after('guardian_email');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'g_office_addr') == false) {
                $table->string('g_office_addr',500)->after('guardian_address')->nullable();
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'guardian_relationship') == false) {
                $table->string('guardian_relationship',500)->after('g_office_addr');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'created_by') == false) {
                $table->integer('created_by')->after('guardian_relationship')->nullable();
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'updated_by') == false) {
                $table->integer('updated_by')->after('created_by')->nullable();
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'fee_paid') == false) {
                $table->char('fee_paid',1)->default('N')->after('guardian_relationship');
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
        //
    }
}
