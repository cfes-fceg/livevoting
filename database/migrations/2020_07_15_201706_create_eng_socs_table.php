<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngSocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eng_socs', function(Blueprint $table)
        {
            $table->id();
            $table->timestamps();
            $table->string('name', 255)->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('voter_id')->nullable()->unique();
            $table->foreign('voter_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('eng_socs');
    }
}
