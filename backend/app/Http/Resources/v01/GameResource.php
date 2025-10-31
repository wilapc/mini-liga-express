<?php

namespace App\Http\Resources\v01;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'home_team' => $this->team->name,
            'away_team' => $this->away->name,
            'home_score' => $this->home_score,
            'away_score' => $this->away_score,
            'played_at' => $this->played_at
        ];
    }
}
