<?php

namespace Tests\Exchange\Portfolio;

use Modules\Exchange\database\factories\AssetFactory;
use Modules\Exchange\database\factories\PositionFactory;
use Modules\Exchange\Money;
use Modules\Exchange\Portfolio\Position;
use Modules\Exchange\Quantity;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PositionTest extends TestCase
{
    #[Test]
    public function it_calculates_the_total_invested(): void
    {
        $asset = AssetFactory::new()->create(['ticker' => 'AAPL', 'current_price' => Money::USD(10)]);
        $position = PositionFactory::new()->recycle($asset)->create();

        $position->buy(Quantity::make(10), Money::USD(5));

        $this->assertEquals(Money::USD(50), $position->totalInvested());
        $this->assertEquals($asset->current_price->multiply(10), $position->marketValue());
    }

    #[Test]
    public function it_calculates_the_position_details(): void
    {
        $asset = AssetFactory::new()->create(['ticker' => 'AAPL', 'current_price' => Money::USD(10)]);
        /** @var Position $position */
        $position = PositionFactory::new()->recycle($asset)->create();

        $position->buy(Quantity::make(10), Money::USD(5));

        $this->assertEquals(10, (int) $position->currentDetails->quantity->toFloat());
        $this->assertEquals((10 - 5) * 10, (int) $position->currentDetails->profit);

        $position->sell(Quantity::make(5), Money::USD(10));

        $position->refresh();

        $this->assertEquals(Money::USD(25), $position->totalInvested());
        $this->assertEquals($asset->current_price->multiply(5), $position->marketValue());
    }

    #[Test]
    public function it_calculates_the_profit()
    {
        $this->markTestSkipped();
    }
}
