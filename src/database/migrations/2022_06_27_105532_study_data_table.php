<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudyDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_data', function (Blueprint $table) {
            $table->bigIncrements('data_id');
            $table->integer('user_id');
            $table->integer('content_id');
            $table->integer('language_id');
            $table->integer('hours');
            $table->datetime('posted_at');
            $table->foreign('content_id')->references('id')->on('contents');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_data');
    }
}
