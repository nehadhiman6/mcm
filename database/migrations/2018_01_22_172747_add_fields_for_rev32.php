<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev32 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('fee_rcpts', function (Blueprint $table) {
            $table->index('rcpt_date', 'fee_rcpts_rcpt_date_index');
        });
        Schema::connection('mysql_yr')->table('fee_rcpt_dets', function (Blueprint $table) {
            $table->index('feehead_id', 'fee_rcpt_dets_feehead_id_index');
        });
        Schema::connection('mysql_yr')->table('payments', function (Blueprint $table) {
            $table->index('fee_rcpt_id', 'payments_fee_rcpt_id_index');
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
            Schema::connection('mysql_yr')->table('fee_rcpts', function (Blueprint $table) {
                $table->dropIndex('fee_rcpts_rcpt_date_index');
            });
        } catch (Exception $ex) {
            echo 'Index not found!';
        }
        try {
            Schema::connection('mysql_yr')->table('fee_rcpt_dets', function (Blueprint $table) {
                $table->dropIndex('fee_rcpt_dets_feehead_id_index');
            });
        } catch (Exception $ex) {
            echo 'Index not found!';
        }
        try {
            Schema::connection('mysql_yr')->table('payments', function (Blueprint $table) {
                $table->dropIndex('payments_fee_rcpt_id_index');
            });
        } catch (Exception $ex) {
            echo 'Index not found!';
        }
    }
}
