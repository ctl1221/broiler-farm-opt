<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptimizerRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optimizer_runs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contract_id');
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->string('n_farms');
            $table->timestamps();
        });

        Schema::table('results_header', function (Blueprint $table) {
            $table->foreign('run_id')->references('id')->on('optimizer_runs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('optimizer_runs');

        Schema::table('results_header', function (Blueprint $table) {
            $table->dropForeign(['run_id']);
        });
    }
}
