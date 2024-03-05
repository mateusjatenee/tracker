<?php

namespace Modules\Exchange\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Exchange\Portfolio\Transaction;
use Modules\Exchange\Portfolio\TransactionType;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'performed_at' => Carbon::now(),
            'quantity' => $this->faker->randomFloat(),
            'type' => $this->faker->randomElement(TransactionType::cases()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
