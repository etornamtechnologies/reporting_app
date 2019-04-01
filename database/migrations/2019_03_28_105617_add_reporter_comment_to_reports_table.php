<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReporterCommentToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->text('walk_in_comment')->nullable();
            $table->text('phone_in_comment')->nullable();
            $table->string('reporter_name')->nullable();
            $table->integer('industry_previous_num')->nullable();
            $table->integer('industry_previous_den')->nullable();
            $table->integer('industry_current_num')->nullable();
            $table->integer('industry_current_den')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
}
