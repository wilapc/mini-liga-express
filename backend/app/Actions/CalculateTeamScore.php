<?php

use App\Models\Team;

class CalculateTeamScore 
{
    protected $data;
    protected Team $team;

    public function __construct(array $request)
    {
        $this->data = $request;
    }

    public function execute()
    {
        $this->homeTeam();
        $this->awayTeam();
    }

    public function homeTeam()
    {
        $this->team::find($this->data['home_team_id']);
        $this->team->increment('goals_for', $this->data['home_score']);
        $this->team->increment('goals_against', $this->data['away_score']);
    }

    public function awayTeam()
    {
        $this->team::find($this->data['away_team_id']);
        $this->team->increment('goals_for', $this->data['away_score']);
        $this->team->increment('goals_against', $this->data['home_score']);
    }
}