<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmRentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_rent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('film_id')->unsigned();
            $table->bigInteger('rent_id')->unsigned();
            $table->foreign('film_id')->references('id')->on('films');
            $table->foreign('rent_id')->references('id')->on('rents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_film');
    }
}
