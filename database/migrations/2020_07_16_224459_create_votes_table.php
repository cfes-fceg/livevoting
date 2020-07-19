<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vote', 100);
            $table->unsignedBigInteger('voter_id');
            $table->unsignedBigInteger('eng_soc_id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('voter_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('eng_soc_id')->references('id')->on('eng_socs')->onDelete('restrict');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('restrict');
            $table->unique(['eng_soc_id', 'question_id'], 'eng_soc_question_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
