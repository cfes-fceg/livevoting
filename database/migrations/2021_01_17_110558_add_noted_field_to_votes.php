<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotedFieldToVotes extends Migration
{
    public function up()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->boolean('noted')->default(false);
        });
    }

    public function down()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropColumn('noted');
        });
    }
}
