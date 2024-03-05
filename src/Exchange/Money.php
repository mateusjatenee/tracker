<?php

declare(strict_types=1);

namespace Modules\Exchange;

readonly class Money
{
    public const PRECISION = 100000000;

    protected int $value;

    public function __construct(float|int|string $value)
    {
        if (! is_numeric($value)) {
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
        return $this->backToBaseUnit();
    }

    public function backToBaseUnit(): float
    {
        return $this->value / self::PRECISION;
    }

    public function subtract(Money|float $money): Money
    {
        if ($money instanceof self) {
            return new self($this->backToBaseUnit() - $money->backToBaseUnit());
        }

        return new self($this->backToBaseUnit() - $money);
    }

    public function multiply(Money|float $money): Money
    {
        if ($money instanceof self) {
            return new self($this->backToBaseUnit() * $money->backToBaseUnit());
        }

        return new self($this->backToBaseUnit() * $money);
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
