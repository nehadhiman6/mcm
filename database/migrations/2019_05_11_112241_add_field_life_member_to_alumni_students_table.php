<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldLifeMemberToAlumniStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasColumn('alumni_students', 'life_member') == false) {
            Schema::table('alumni_students', function (Blueprint $table) {
                $table->char('life_member', 1)->default('N')->nullable()->after('is_graduacted');
            });
        }
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
