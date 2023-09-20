<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledsForRev29 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('fee_bill_dets', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('fee_bill_dets', 'subject_id') == false) {
              $table->integer('subject_id')->default(0)->after('index_no');
            }
            if (Schema::connection('mysql_yr')->hasColumn('fee_bill_dets', 'sub_type') == false) {
                $table->string('sub_type',10)->default('')->after('subject_id');
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
