<?php

namespace Modules\Exchange\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Exchange\Asset\Asset;
use Modules\Exchange\Asset\AssetType;
use Money\Money;

class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition(): array
    {
        return [
            'ticker' => $this->faker->randomElement(['AAPL', 'TSLA', 'NVDA']),
            'type' => AssetType::Stock,
            'current_price' => Money::USD($this->faker->randomNumber(4)),
            'currency' => 'USD',
        ];
    }

    public function crypto(): static
    {
        return $this->state([
            'type' => AssetType::Crypto,
        ]);
    }
}
