<?php

namespace Modules\Exchange\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Exchange\Asset\AssetPrice;

class AssetPriceFactory extends Factory
{
    protected $model = AssetPrice::class;

    public function definition(): array
    {
        return [
            'asset_id' => $this->faker->randomNumber(),
            'price' => $this->faker->randomNumber(),
            'currency' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
