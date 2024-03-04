<?php

namespace Modules\Exchange\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Exchange\Portfolio\PositionDetails;

class PositionDetailsFactory extends Factory
{
    protected $model = PositionDetails::class;

    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomFloat(),
            'average_price' => $this->faker->randomNumber(),
            'current_market_price' => $this->faker->randomNumber(),
            'profit' => $this->faker->randomNumber(),
            'currency' => $this->faker->word(),
            'calculated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
