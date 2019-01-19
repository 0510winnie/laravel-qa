<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votables', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('votable_id');
            // this column name should be the singular form of the table name
            $table->string('votable_type');
            $table->tinyInteger('vote')->comment('-1: vote down, 1: vote up');
            // use tinyinteger since this column will only contain 2 possible numbers, 1 to represent vote up, -1:vote down
            $table->timestamps();
            $table->unique(['user_id', 'votable_id', 'votable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votables');
    }
}
