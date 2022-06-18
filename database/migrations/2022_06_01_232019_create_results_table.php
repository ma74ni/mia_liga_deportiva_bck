<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('local_team_id');
            $table->unsignedBigInteger('tournament_id');
            $table->integer('number_match');
            $table->integer('local_goals');
            $table->integer('visit_goals');
            $table->unsignedBigInteger('visit_team_id');
            $table->integer('points');
            $table->datetime('date');
            $table->timestamps();

            $table-> foreign('local_team_id')->references('id')->on('teams')->onUpdate('cascade')->onDelete('cascade');
            $table-> foreign('tournament_id')->references('id')->on('tournaments')->onUpdate('cascade')->onDelete('cascade');
            $table-> foreign('visit_team_id')->references('id')->on('teams')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('results', function (Blueprint $table){
            $table->dropForeign(['local_team_id']);
            $table->dropForeign(['visit_team_id']);
            $table->dropForeign(['tournament_id']);
        });
        Schema::dropIfExists('results');
    }
}
