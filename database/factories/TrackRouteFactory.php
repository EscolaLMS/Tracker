<?php

namespace EscolaLms\Tracker\Database\Factories;

use EscolaLms\Core\Models\User;
use EscolaLms\Tracker\Models\TrackRoute;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackRouteFactory extends Factory
{
    protected $model = TrackRoute::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'path' => $this->faker->slug,
            'full_path' => $this->faker->slug . '?' . $this->faker->slug,
            'method' => $this->faker->randomElement(['GET', 'DELETE', 'POST', 'PUT']),
        ];
    }
}
