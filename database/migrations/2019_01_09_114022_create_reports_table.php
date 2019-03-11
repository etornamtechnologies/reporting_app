<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label')->unique();
            $table->integer('previous_num')->nullable();
            $table->integer('previous_den')->nullable();
            $table->integer('current_num')->nullable();
            $table->integer('current_den')->nullable();
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')
                  ->references('id')->on('companies');
            $table->unsignedInteger('branch_id');
            $table->foreign('branch_id')
                ->references('id')->on('branches');      
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')->on('users');
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
        Schema::dropIfExists('reports');
    }
}
