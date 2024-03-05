<?php

namespace Tests\Exchange\Portfolio;

use Modules\Exchange\database\factories\AccountFactory;
use Modules\Exchange\database\factories\AssetFactory;
use Modules\Exchange\database\factories\PositionFactory;
use Modules\Exchange\Portfolio\Position;
use Money\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PositionTest extends TestCase
{
    #[Test]
    public function it_calculates_the_total_invested(): void
    {
        $asset = AssetFactory::new()->create(['ticker' => 'AAPL', 'current_price' => Money::USD(1000)]);
        $position = PositionFactory::new()->recycle($asset)->create();

        $position->buy(10, 5);

        $this->assertEquals(Money::USD(5000), $position->totalInvested());
        $this->assertEquals($asset->current_price->multiply(10), $position->marketValue());
    }

    #[Test]
    public function it_calculates_the_position_details(): void
    {
        $asset = AssetFactory::new()->create(['ticker' => 'AAPL', 'current_price' => Money::USD(1000)]);
        /** @var Position $position */
        $position = PositionFactory::new()->recycle($asset)->create();

        $position->buy(10, 5);

        $this->assertEquals(10, (int) $position->currentDetails->quantity);
        $this->assertEquals((10 - 5 ) * 10, (int) $position->currentDetails->profit);

        $position->sell(5, 10);

        $position->refresh();

        $this->assertEquals(Money::USD(2500), $position->totalInvested());
        $this->assertEquals($asset->current_price->multiply(5), $position->marketValue());
    }

    #[Test]
    public function it_calculates_the_profit()
    {
        $this->markTestSkipped();
    }
}
