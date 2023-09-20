<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePaperStatusAndPublisherFieldChangeInResearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('researches', function (Blueprint $table) {
            if (Schema::hasColumn('researches', 'paper_status') == true) {
                $table->string('paper_status', 30)->nullable()->change();
            }
            if (Schema::hasColumn('researches', 'level') == true) {
                $table->string('publisher', 200)->nullable()->change();
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
