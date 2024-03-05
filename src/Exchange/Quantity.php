<?php

declare(strict_types=1);

namespace Modules\Exchange;

readonly class Quantity
{
    public const PRECISION = 100000000;

    public int $value;

    public function __construct(float|int|string $value)
    {
        if (! is_numeric($value)) {
            throw new \InvalidArgumentException('Value must be numeric');
        }

        $this->value = $this->normalizeValue($value);
    }

    public static function make(mixed $value): Quantity
    {
        return new Quantity($value);
    }

    public function asFloat(): float
    {
        return $this->backToBaseUnit();
    }

    public function backToBaseUnit(): float
    {
        return $this->value / self::PRECISION;
    }

    public function __toString(): string
    {
        return (string) $this->backToBaseUnit();
    }

    private function normalizeValue(float|int|string $value): int
    {
        return (int) ($value * self::PRECISION);
    }
}
