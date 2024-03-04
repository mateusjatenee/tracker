<?php

namespace Modules\Exchange\Portfolio;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Modules\Exchange\Asset\Asset;
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

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, Position::class);
    }

    public function addTransaction(TransactionType $type, Asset $asset, Money $totalPaid, int $quantity): void
    {
        $position = $this->fetchPositionForAsset($asset);

        Transaction::register(
            $type,
            $totalPaid,
            $quantity,
            $position,
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

    public function fetchPositionForAsset(Asset $asset): Position
    {
        return $this->positions()->firstOrCreate([
            'asset_id' => $asset->id,
        ]);
    }
}
