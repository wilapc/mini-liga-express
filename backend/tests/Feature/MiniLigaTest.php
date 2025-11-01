<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiniLigaTest extends TestCase
{
    use RefreshDatabase;

    public function test_calcula_correctamente_los_puntos_y_posiciones()
    {
        $teamA = Team::factory()->create(['name' => 'Dragons']);
        $teamB = Team::factory()->create(['name' => 'Sharks']);
        $teamC = Team::factory()->create(['name' => 'Tigers']);
        
        $match1 = Game::create([
            'home_team_id' => $teamA->id,
            'away_team_id' => $teamB->id,
        ]);

        $match2 = Game::create([
            'home_team_id' => $teamA->id,
            'away_team_id' => $teamC->id,
        ]);

        $this->postJson("/api/games/{$match1->id}/result", [
            'home_score' => 2,
            'away_score' => 0,
        ])->assertOk();

        $this->postJson("/api/games/{$match2->id}/result", [
            'home_score' => 1,
            'away_score' => 1,
        ])->assertOk();

        $response = $this->getJson('/api/standings')->assertOk();

        $standings = $response->json();

        $dragons = collect($standings)->firstWhere('name', 'Dragons');
        $sharks  = collect($standings)->firstWhere('name', 'Sharks');
        $tigers  = collect($standings)->firstWhere('name', 'Tigers');

        $this->assertEquals(4, $dragons['points']);
        $this->assertEquals(0, $sharks['points']);
        $this->assertEquals(1, $tigers['points']);

        $this->assertEquals(3, $dragons['goals_for']);
        $this->assertEquals(1, $dragons['goals_against']);
        $this->assertEquals(2, $dragons['goal_diff']);
    }
}
