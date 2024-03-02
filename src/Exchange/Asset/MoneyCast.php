<?php

declare(strict_types=1);

namespace Modules\Exchange\Asset;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Money\Currency;
use Money\Money;

class MoneyCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): Money
    {
        return new Money($value, new Currency($attributes['currency']));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        if (! $value instanceof Money) {
            throw new \Exception('Price must be an instance of Money.');
        }

        return (int) $value->getAmount();
    }
}
