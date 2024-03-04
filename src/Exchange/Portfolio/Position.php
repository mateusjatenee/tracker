<?php

namespace Modules\Exchange\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Exchange\Asset\Asset;

class Position extends Model
{
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
}
