<?php

namespace App\Http\Resources\v01;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'goals_for' => $this->goals_for,
            'goals_against' => $this->goals_against,
        ];
    }
}
