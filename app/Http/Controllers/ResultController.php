<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $response = $this->singleSave($data, $data['tournament']);
        return $response;

    }
    public function massiveStore(Request $request){
        if($request->isJson()){
            $data = $request->all();
            foreach ($data['data'] as $dataResult){
                $this->singleSave($dataResult, $data['tournament']);
            }
            return response()->json(['message'=>'Items guardados']);
        }
        return response()->json(['error' => 'Request not allowed'], 401);

    }
    public function singleSave($data, $tournamentId): array
    {
        $localGoals = $data['local_goals'];
        $visitGoals = $data['visit_goals'];
        $tournament = $this->getTournamentInfo($tournamentId);
        $points = $this->handlePoints($tournament[0], $localGoals, $visitGoals);
        $ptsLocal = $points['local'];
        $ptsVisit = $points['visit'];

        $results = [
            '0'=>[
                'local'=>$data['local'],
                'tournament'=>$data['tournament'],
                'match'=>$data['match'],
                'local_goals'=>$data['local_goals'],
                'visit_goals'=>$data['visit_goals'],
                'visit'=>$data['visit'],
                'points'=>$ptsLocal,
                'date'=>$data['date'],
            ],
            '1'=>[
                'local'=>$data['visit'],
                'tournament'=>$data['tournament'],
                'match'=>$data['match'],
                'local_goals'=>$data['visit_goals'],
                'visit_goals'=>$data['local_goals'],
                'visit'=>$data['local'],
                'points'=>$ptsVisit,
                'date'=>$data['date'],
            ]
        ];

        foreach ($results as $result){
            $newResult = new Result();
            $newResult->local_team_id = $result['local'];
            $newResult->tournament_id = $result['tournament'];
            $newResult->number_match = $result['match'];
            $newResult->local_goals = $result['local_goals'];
            $newResult->visit_goals = $result['visit_goals'];
            $newResult->visit_team_id = $result['visit'];
            $newResult->points = $result['points'];
            $newResult->date = $result['date'];

            $newResult->save();
        }
        return ['message'=>'Item guardado'];
    }
    public function getTournamentInfo ($id): \Illuminate\Support\Collection
    {
        return DB::table('tournaments')
            ->select('win', 'lose', 'draw')
            ->where('id', '=', $id)
            ->get();
    }
    public function handlePoints($tournament, $localGoals, $visitGoals): array
    {
        $win = $tournament->win;
        $lose = $tournament->lose;
        $draw = $tournament->draw;

        $ptsLocal = $lose;
        $ptsVisit = $lose;

        if($localGoals > $visitGoals){
            $ptsLocal = $win;
        }else if($localGoals < $visitGoals){
            $ptsVisit = $win;
        }else{
            $ptsLocal = $draw;
            $ptsVisit = $draw;
        }
        return ['local'=>$ptsLocal, 'visit'=>$ptsVisit];
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
