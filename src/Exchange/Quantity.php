<?php

declare(strict_types=1);

namespace Modules\Exchange;

use Brick\Math\BigDecimal;

final readonly class Quantity
{
    public const SCALE = 8;

    protected BigDecimal $value;

    /**
     * A Quantity VO receives a decimal value and normalizes it to a BigDecimal object.
     * This is needed because Crypto currencies can be negotiated in tiny quantities, such as
     * 0.00000001 BTC, and we need to ensure that the precision is kept. Stocks are simpler.
     *
     * @param  \Brick\Math\BigDecimal|float|int|string  $value
     */
    public function __construct(BigDecimal|float|int|string $value)
    {
        if (! is_numeric($value) && ! $value instanceof BigDecimal) {
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
        return $this->value->toFloat();
    }

    public function subtract(Quantity|float $quantity):Quantity
    {
        $amount = $quantity instanceof self ? $quantity->asFloat() : $quantity;

        return new self($this->value->minus($amount));
    }

    public function multiply(Quantity|float $quantity):Quantity
    {
        $amount = $quantity instanceof self ? $quantity->asFloat() : $quantity;

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
