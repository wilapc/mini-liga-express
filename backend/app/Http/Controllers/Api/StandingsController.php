<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StandingsController extends Controller
{
    public function index()
    {
        $teams = Team::all();

        $standings = $teams->map(fn($team) => $this->calculateTeamStats($team));

        $standings = $this->sortAndAssignPosition($standings);

        return response()->json($standings);
    }

    private function calculateTeamStats(Team $team): array
    {
        $goalsFor = $team->goals_for;
        $goalsAgainst = $team->goals_against;
        $points = $this->calculatePoints($team);
        $played = $this->countGames($team);

        return [
            'id' => $team->id,
            'name' => $team->name,
            'played' => $played,
            'points' => $points,
            'goals_against' => $team->goals_against,
            'goals_for' => $goalsFor,
            'goal_diff' => $goalsFor - $goalsAgainst,
        ];
    }

    private function calculatePoints(Team $team): int
    {
        $homePoints = $team->homeGames()->sum(DB::raw('
            CASE
                WHEN home_score > away_score THEN 3
                WHEN home_score = away_score THEN 1
                ELSE 0
            END
        '));

        $awayPoints = $team->awayGames()->sum(DB::raw('
            CASE
                WHEN away_score > home_score THEN 3
                WHEN away_score = home_score THEN 1
                ELSE 0
            END
        '));

        return $homePoints + $awayPoints;
    }

    private function countGames(Team $team): int
    {
        return $team->homeGames()->count() + $team->awayGames()->count();
    }

    private function sortAndAssignPosition($standings)
    {
        return $standings->sortByDesc('points')
                         ->values()
                         ->map(fn($team, $index) => array_merge($team, ['position' => $index + 1]));
    }
}
