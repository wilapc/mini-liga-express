<?php
namespace App\Actions;

use App\Models\Team;

class CalculateTeamScore 
{
    protected object $data;

    public function __construct(object $request)
    {
        $this->data = $request;
    }

    public function execute()
    {
        $this->homeTeam();
        $this->awayTeam();
    }

    private function homeTeam(): void
    {
        $team = Team::find($this->data->home_team_id);

        if ($team) {
            $team->increment('goals_for', $this->data->home_score);
            $team->increment('goals_against', $this->data->away_score);
        }
    }

    private function awayTeam(): void
    {
        $team = Team::find($this->data->away_team_id);

        if ($team) {
            $team->increment('goals_for', $this->data->away_score);
            $team->increment('goals_against', $this->data->home_score);
        }
    }
}