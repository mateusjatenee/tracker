<?php

namespace Modules\Exchange\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Exchange\MoneyCast;
use Money\Money;

class Position extends Model
{
    protected $casts = [
        'average_price' => MoneyCast::class,
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function total(): Money
    {
        return $this->average_price->multiply($this->quantity);
    }
}
