<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOverallDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overallentries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->decimal('value', 10,2);
            $table->integer('report_id')->unsigned();
            $table->foreign('report_id')
                    ->references('id')->on('reports')->onDelete('cascade');
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
        Schema::dropIfExists('overallentries');
    }
}
