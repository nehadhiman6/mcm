<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInResearchAndActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('researches', function (Blueprint $table) {
            if (Schema::hasColumn('researches', 'res_award') == false) {
                $table->string('res_award',100)->nullable()->after('relevant_link');
            }
        });

        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'sponsor_amt') == false) {
                $table->decimal('sponsor_amt', 12, 2)->default(0)->after('sponsor_address');
            }
        });

        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'aegis') == false) {
                $table->string('aegis',250)->nullable()->after('sponsor_amt');
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
