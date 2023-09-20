<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevIntoActivitiesEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function ($table) {
            $table->dropColumn(['guest_name', 'guest_designation', 'guest_affiliation']);
        });

        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'remarks') == false) {
                $table->string('remarks',500)->nullable()->after('outsider_nonteaching');
            }
        });

        Schema::create('activity_guests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('act_id');
            $table->integer('order_no');
            $table->string('guest_name',50)->nullable();
            $table->string('guest_designation',150)->nullable();
            $table->string('guest_affiliation',100)->nullable();
            $table->string('address',500)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guests');
    }
}
