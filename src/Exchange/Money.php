<?php

declare(strict_types=1);

namespace Modules\Exchange;

use Brick\Math\BigDecimal;

final readonly class Money implements DecimalValue
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

    public function toFloat(): float
    {
        return $this->value->toFloat();
    }

    public function subtract(DecimalValue|float $money): Money
    {
        $amount = $money instanceof DecimalValue ? $money->toFloat() : $money;

        return new self($this->value->minus($amount));
    }

    public function multiply(DecimalValue|float $money): Money
    {
        $amount = $money instanceof DecimalValue ? $money->toFloat() : $money;

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
