<?php

namespace Modules\Exchange\database\factories;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Exchange\Portfolio\Account;
use Modules\Exchange\Portfolio\AccountType;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type' => $this->faker->randomElement(AccountType::cases()),
            'provider' => $this->faker->word(),
            'user_id' => UserFactory::new(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function stock(): static
    {
        return $this->state([
            'type' => AccountType::Stock,
        ]);
    }

    public function crypto(): static
    {
        return $this->state([
            'type' => AccountType::Crypto,
        ]);
    }
}
