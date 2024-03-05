<?php

namespace Modules\Exchange\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Exchange\Money;
use Modules\Exchange\MoneyCast;
use Modules\Exchange\Quantity;
use Modules\Exchange\QuantityCast;

class PositionDetails extends Model
{
    use HasFactory;

    protected $casts = [
        'calculated_at' => 'datetime',
        'quantity' => QuantityCast::class,
        'average_price' => MoneyCast::class,
        'current_market_price' => MoneyCast::class,
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public static function calculate(Position $position): void
    {
        $profit = $position->asset->current_price->subtract(
            $position->averagePrice()
        )->multiply($position->currentQuantity());
        
        self::create([
            'quantity' => Quantity::make($position->transactions->sum(fn (Transaction $t) => $t->quantity->toFloat())),
            'average_price' => Money::USD($position->transactions->avg(fn (Transaction $t) => $t->amount_paid_per_unit->toFloat())),
            'current_market_price' => $position->asset->current_price,
            'profit' => $profit,
            'currency' => $position->asset->currency,
            'calculated_at' => now(),
            'position_id' => $position->id,
        ]);
    }
}
