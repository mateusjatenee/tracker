<?php

declare(strict_types=1);

namespace Modules\Exchange;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): Money
    {
        return new Money($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if (! $value instanceof Money) {
            throw new \Exception($key.' must be an instance of '.Money::class);
        }

        return (string) $value;
    }
}
