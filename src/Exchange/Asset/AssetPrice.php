<?php

namespace Modules\Exchange\Asset;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetPrice extends Model
{
    protected $casts = [
        'price' => MoneyCast::class,
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public static function track(Asset $asset): void
    {
        self::create([
            'currency' => $asset->currency,
            'price' => $asset->current_price,
            'asset_id' => $asset->id,
        ]);
    }
}
