<?php

namespace Modules\Exchange\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Exchange\Asset\Asset;
use Modules\Exchange\Money;
use Modules\Exchange\Quantity;

class Position extends Model
{
    protected $with = [
            'details',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(PositionDetails::class);
    }

    public function currentDetails(): HasOne
    {
        return $this->hasOne(PositionDetails::class)->latestOfMany();
    }

    public function addTransaction(Quantity $quantity, Money $amountPaidPerUnit, TransactionType $type): Transaction
    {
        $transaction = Transaction::register(
            $type,
            $amountPaidPerUnit,
            $quantity,
            $this
        );

        PositionDetails::calculate($this);

        return $transaction;
    }

    public function buy(Quantity $quantity, Money $amountPaidPerUnit): Transaction
    {
        return $this->addTransaction($quantity, $amountPaidPerUnit, TransactionType::Buy);
    }

    public function sell(Quantity $quantity, Money $amountPaidPerUnit): Transaction
    {
        return $this->addTransaction($quantity, $amountPaidPerUnit, TransactionType::Sell);
    }

    public function averagePrice(): float
    {
        return $this->transactions->filter(
            fn (Transaction $transaction) => $transaction->isBuy()
        )->avg(fn (Transaction $t) => $t->amount_paid_per_unit->asFloat());
    }

    public function currentQuantity(): int
    {
        return $this->transactions->sum(fn (Transaction $transaction) => $transaction->relativeQuantity());
    }

    public function totalInvested(): Money
    {
        return Money::USD((int) ($this->currentQuantity() * $this->averagePrice() * 100));
    }

    public function marketValue(): Money
    {
        return $this->asset->current_price->multiply($this->currentQuantity());
    }
}

