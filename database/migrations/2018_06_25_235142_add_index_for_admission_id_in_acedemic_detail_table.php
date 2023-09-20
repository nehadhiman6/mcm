<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexForAdmissionIdInAcedemicDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('academic_detail', function (Blueprint $table) {
            $table->index('admission_id', 'academic_detail_admission_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            Schema::connection('mysql_yr')->table('academic_detail', function (Blueprint $table) {
                $table->dropIndex('academic_detail_admission_id_index');
            });
        } catch (\Exception $ex) {
            echo 'Index not found!';
        }
    }
}
