<?php

namespace Modules\Exchange\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Exchange\Asset\Asset;
use Modules\Exchange\Money;
use Modules\Exchange\MoneyCast;
use Modules\Exchange\Quantity;
use Modules\Exchange\QuantityCast;
use Money\Currency;

class Transaction extends Model
{
    protected $casts = [
        'performed_at' => 'datetime',
        'type' => TransactionType::class,
        'quantity' => QuantityCast::class,
        'market_price_per_unit' => MoneyCast::class,
        'amount_paid_per_unit' => MoneyCast::class,
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public static function register(
        TransactionType $type,
        Money $amountPaidPerUnit,
        Quantity $quantity,
        Position $position,
    ): Transaction {
        return self::create([
            'quantity' => $quantity,
            'type' => $type,
            'market_price_per_unit' => $position->asset->current_price,
            'amount_paid_per_unit' => $amountPaidPerUnit,
            'performed_at' => now(),
            'position_id' => $position->id,
            'asset_id' => $position->asset_id,
            'currency' => $position->asset->currency,
        ]);
    }

    public function isSell(): bool
    {
        return $this->type === TransactionType::Sell;
    }

    public function isBuy(): bool
    {
        return $this->type === TransactionType::Buy;
    }

    public function relativeQuantity(): int
    {
        return $this->isSell() ? -1 * $this->quantity->asFloat() : $this->quantity->asFloat();
    }

    public function total(): Money
    {
        $totalInCents = $this->amount_paid_per_unit * $this->quantity * 100;

        return new Money($totalInCents);
    }

    public function marketValue(Money $currentPrice): Money
    {
        return $currentPrice->multiply($this->quantity);
    }
}
