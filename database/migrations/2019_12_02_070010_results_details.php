<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ResultsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('header_id');
            $table->foreign('header_id')->references('id')->on('results_header')->onDelete('cascade');
            $table->string('farm');
            $table->integer('birds');
            $table->integer('feeds_consumed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results_details');
    }
}
