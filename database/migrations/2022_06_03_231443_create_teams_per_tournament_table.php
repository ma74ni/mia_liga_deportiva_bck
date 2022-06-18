<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsPerTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_per_tournament', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('tournament_id');
            $table->integer('order');
            $table->timestamps();

            $table-> foreign('team_id')->references('id')->on('teams')->onUpdate('cascade')->onDelete('cascade');
            $table-> foreign('tournament_id')->references('id')->on('tournaments')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams_per_tournament', function (Blueprint $table){
            $table->dropForeign(['tournament_id']);
            $table->dropForeign(['team_id']);

        });
        Schema::dropIfExists('teams_per_tournament');
    }
}
