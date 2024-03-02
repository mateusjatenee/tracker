<?php

namespace Modules\Exchange\Asset;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Money\Money;

class Asset extends Model
{
    protected $casts = [
        'type' => AssetType::class,
        'current_price' => MoneyCast::class,
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(AssetPrice::class);
    }

    public function updateCurrentPrice(Money $money): void
    {
        $this->getConnection()->transaction(function () use ($money) {
            $this->update(['current_price' => $money]);
            $this->prices()->save(new AssetPrice([
                'currency' => $this->currency,
                'price' => $money,
            ]));
        });
    }
}
