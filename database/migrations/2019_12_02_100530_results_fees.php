<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ResultsFees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('detail_id');
            $table->foreign('detail_id')->references('id')->on('results_details')->onDelete('cascade');
            $table->string('rate_category');
            $table->string('rate_name');
            $table->double('rate_value');
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
        Schema::dropIfExists('results_fees');
    }
}
