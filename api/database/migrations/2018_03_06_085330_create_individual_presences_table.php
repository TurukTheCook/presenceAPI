<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualPresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_presences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('apprenant_id')->unsigned();
            $table->integer('presence_id')->unsigned();
            $table->boolean('absent_matin')->default(true);
            $table->boolean('absent_aprem')->default(true);
            $table->timestamps();

            $table->foreign('apprenant_id')->references('id')->on('apprenants');
            $table->foreign('presence_id')->references('id')->on('presences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individual_presences');
    }
}
