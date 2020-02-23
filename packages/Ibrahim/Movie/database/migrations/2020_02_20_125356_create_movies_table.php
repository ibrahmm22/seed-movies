<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('movie_id')->index();
            $table->float('popularity');
            $table->integer('vote_count');
            $table->boolean('video');
            $table->text('poster_path');
            $table->boolean('adult');
            $table->text('backdrop_path')->nullable();
            $table->string('original_language');
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
        Schema::dropIfExists('movies');
    }
}
