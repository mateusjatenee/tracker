<?php

declare(strict_types=1);

namespace Modules\Exchange;

use Brick\Math\BigDecimal;

final readonly class Money
{
    public const SCALE = 8;

    protected BigDecimal $value;

    public function __construct(BigDecimal|float|int|string $value)
    {
        if (! is_numeric($value) && ! $value instanceof BigDecimal) {
            throw new \InvalidArgumentException('Value must be numeric');
        }

        $this->value = $this->normalizeValue($value);
    }

    public static function USD(float|int|string $value): Money
    {
        return new self($value);
    }

    public function asFloat(): float
    {
        return $this->value->toFloat();
    }

    public function subtract(Money|float $money): Money
    {
        $amount = $money instanceof self ? $money->asFloat() : $money;

        return new self($this->value->minus($amount));
    }

    public function multiply(Money|float $money): Money
    {
        $amount = $money instanceof self ? $money->asFloat() : $money;

        return new self($this->value->multipliedBy($amount));
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    private function normalizeValue(BigDecimal|float|int|string $value): BigDecimal
    {
        return BigDecimal::of($value)->toScale(self::SCALE);
    }
}
