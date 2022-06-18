<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeamController extends Controller
{
    public function tournamentTeams(Request $request){
        $data = $request->all();
        $teams = DB::table('teams_per_tournament')
            ->join('teams', 'teams_per_tournament.team_id', '=', 'teams.id')
            ->select('teams.name')
            ->where('teams_per_tournament.tournament_id', '=', $data['tournament'])
            ->orderBy('teams_per_tournament.order', 'asc')
            ->get();
        return response()->json($teams);
    }
}
