<?php

namespace Modules\Exchange\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PositionDetails extends Model
{
    use HasFactory;

    protected $casts = [
        'calculated_at' => 'datetime',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public static function calculate(Position $position): void
    {
        $profit = (
            $position->asset->current_price->getAmount() / 100 - $position->transactions->avg('amount_paid_per_unit')
        ) * $position->transactions->sum('quantity');

        self::create([
            'quantity' => $position->transactions->sum('quantity'),
            'average_price' => $position->transactions->avg('amount_paid_per_unit'),
            'current_market_price' => $position->asset->current_price->getAmount() / 100,
            'profit' => $profit,
            'currency' => $position->asset->currency,
            'calculated_at' => now(),
            'position_id' => $position->id,
        ]);
    }
}
