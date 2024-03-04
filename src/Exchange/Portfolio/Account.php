<?php

namespace Modules\Exchange\Portfolio;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Modules\Exchange\Asset\Asset;
use Modules\Exchange\MoneyCast;
use Money\Money;

class Account extends Model
{
    protected $casts = [
        'type' => AccountType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function addTransaction(TransactionType $type, Asset $asset, Money $totalPaid, int $quantity): void
    {
        Transaction::register(
            $type,
            $asset,
            $totalPaid,
            $quantity,
            $this,
        );
    }

    // TODO: It might be better to just always use the price per unit and then calculate the totals @ runtime...
    public function buy(Asset $asset, int $quantity, Money $totalPaid): void
    {
        $this->addTransaction(
            TransactionType::Buy,
            $asset,
            $totalPaid,
            $quantity
        );
    }

    public function sell(Asset $asset, int $quantity, Money $totalPaid): void
    {
        $this->addTransaction(
            TransactionType::Sell,
            $asset,
            $totalPaid,
            $quantity
        );
    }
}
