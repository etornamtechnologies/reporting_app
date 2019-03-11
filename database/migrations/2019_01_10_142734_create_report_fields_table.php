<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->integer('report_type_id')->unsigned();
            $table->foreign('report_type_id')
                  ->references('id')->on('report_types')->onDelete('cascade');
            $table->enum('approve', ['yes', 'no']);
            $table->integer('numerator');
            $table->integer('denumerator');      
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
        Schema::dropIfExists('report_fields');
    }
}
