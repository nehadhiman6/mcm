<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexOnStdIdInStudentFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('student_feedback', function (Blueprint $table) {
            $table->index('std_id', 'student_feedback_std_id_index');
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
            Schema::connection('mysql_yr')->table('student_feedback', function (Blueprint $table) {
                $table->dropIndex('student_feedback_std_id_index');
            });
        } catch (Exception $ex) {
            echo 'Index not found!';
        }
    }
}
