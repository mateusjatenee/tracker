<?php

namespace Modules\Exchange\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Exchange\Asset\Asset;
use Modules\Exchange\MoneyCast;
use Money\Money;

class Transaction extends Model
{
    protected $casts = [
        'performed_at' => 'datetime',
        'type' => TransactionType::class,
        'market_price_per_unit' => MoneyCast::class,
        'amount_paid' => MoneyCast::class,
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public static function register(
        TransactionType $type,
        Asset $asset,
        Money $totalPaid,
        int $quantity,
        Account $account,
    ): Transaction
    {
        return self::create([
            'quantity' => $quantity,
            'type' => $type,
            'market_price_per_unit' => $asset->current_price,
            'amount_paid' => $totalPaid,
            'performed_at' => now(),
            'account_id' => $account->id,
            'asset_id' => $asset->id,
            'currency' => $asset->currency,
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
}
