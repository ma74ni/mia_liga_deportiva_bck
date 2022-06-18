<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->unsignedBigInteger('local_team_id');
            $table->unsignedBigInteger('visit_team_id');
            $table->timestamps();

            $table-> foreign('local_team_id')->references('id')->on('teams')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('matches', function (Blueprint $table){
            $table->dropForeign(['local_team_id']);
            $table->dropForeign(['visit_team_id']);
        });
        Schema::dropIfExists('matches');
    }
}
