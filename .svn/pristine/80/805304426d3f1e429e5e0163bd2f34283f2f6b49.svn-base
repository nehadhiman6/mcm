<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForRev49 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('alumni_students', 'std_id') == false) {
            Schema::table('alumni_students', function (Blueprint $table) {
                $table->integer('std_id')->default(0)->after('alumni_user_id');
            });
        }
        if (Schema::hasColumn('alumni_students', 'session') == false) {
            Schema::table('alumni_students', function (Blueprint $table) {
                $table->string('session', 10)->default('')->after('is_graduacted');
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
