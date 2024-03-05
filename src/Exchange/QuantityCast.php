<?php

declare(strict_types=1);

namespace Modules\Exchange;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class QuantityCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): Quantity
    {
        return new Quantity($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if (! $value instanceof Quantity) {
            throw new \Exception($key . ' must be an instance of ' . Quantity::class);
        }

        return (string) $value;
    }
}
