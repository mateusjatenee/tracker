<?php

namespace Modules\Exchange\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Exchange\Portfolio\Position;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition(): array
    {
        return [
            'account_id' => AccountFactory::new()->stock(),
            'asset_id' => AssetFactory::new(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
