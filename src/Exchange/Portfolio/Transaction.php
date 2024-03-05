<?php

namespace Modules\Exchange\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Exchange\Asset\Asset;
use Modules\Exchange\MoneyCast;
use Money\Currency;
use Money\Money;

class Transaction extends Model
{
    protected $casts = [
        'performed_at' => 'datetime',
        'type' => TransactionType::class,
        'market_price_per_unit' => 'decimal:4',
        'amount_paid_per_unit' => 'decimal:4',
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
        float $amountPaidPerUnit,
        int $quantity,
        Position $position,
    ): Transaction {
        return self::create([
            'quantity' => $quantity,
            'type' => $type,
            'market_price_per_unit' => (int) $position->asset->current_price->getAmount() / 100,
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
        return $this->isSell() ? -1 * $this->quantity : $this->quantity;
    }

    public function total(): Money
    {
        $totalInCents = $this->amount_paid_per_unit * $this->quantity * 100;

        return new Money($totalInCents, new Currency($this->currency));
    }

    public function marketValue(Money $currentPrice): Money
    {
        return $currentPrice->multiply($this->quantity);
    }
}
