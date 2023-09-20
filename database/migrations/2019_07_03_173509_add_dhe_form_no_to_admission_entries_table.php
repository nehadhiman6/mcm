<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDheFormNoToAdmissionEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('mysql_yr')->hasColumn('admission_entries', 'dhe_form_no') == false) {
            Schema::connection('mysql_yr')->table('admission_entries', function (Blueprint $table) {
                $table->string('dhe_form_no', 25)->nullable()->after('manual_formno');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { }
}
