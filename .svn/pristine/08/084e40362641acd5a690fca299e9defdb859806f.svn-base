<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadAttachemntTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name', 100);
            $table->string('file_ext', 10);
            $table->string('mime_type', 100)->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });

       Schema::connection('mysql_yr')->create('resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('resourceable_type', 100);
            $table->integer('resourceable_id');
            $table->integer('attachment_id');
            $table->string('remarks', 500)->nullable();
            $table->string('doc_type', 25)->nullable();
            $table->string('doc_description', 50)->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        //
    }
}
