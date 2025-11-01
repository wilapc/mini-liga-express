<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Actions\CalculateTeamScore;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::where('played_at', null)->with(['homeTeam', 'awayTeam'])->get();

        return response()->json($games);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function result(GameRequest $request ,Game $game)
    {   
        $validated = $request->validated();

        $validated['played_at'] = now();

        $game->update($validated);

        (new CalculateTeamScore($game))->execute();

        return response()->json(['success' => 'Creado con Exito!']);
    }
}
