<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAddFieldForRevision extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::connection('mysql_yr')->table('courses', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('courses', 'min_optional') == FALSE) {
                $table->integer('min_optional')->nullable()->after('status');
            }
        });

        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'hostel') == FALSE) {
                $table->char('hostel', 1)->default('N')->after('migration');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'first_name') == FALSE) {
                $table->string('first_name', 30)->nullable()->after('name');
            }
            if (Schema::hasColumn('users', 'last_name') == FALSE) {
                $table->string('last_name', 30)->nullable()->after('first_name');
            }
            if (Schema::hasColumn('users', 'mobile') == FALSE) {
                $table->string('mobile', 10)->nullable()->after('last_name');
            }
            if (Schema::hasColumn('users', 'isStudent') == FALSE) {
                $table->char('isStudent', 1)->default('N')->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'mobile') == true) {
                $table->dropColumn('mobile');
            }
        });
    }

}
