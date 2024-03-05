<?php

declare(strict_types=1);

namespace Tests\Exchange\Asset;

use Modules\Exchange\Asset\Asset;
use Modules\Exchange\database\factories\AssetFactory;
use Modules\Exchange\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AssetTest extends TestCase
{
    #[Test]
    public function it_casts_the_current_price_to_a_money_object(): void
    {
        $asset = new Asset([
            'current_price' => Money::USD(10),
            'currency' => 'USD',
        ]);

        $this->assertInstanceOf(Money::class, $asset->current_price);
        $this->assertEquals(10.0, $asset->current_price->asFloat());
    }

    #[Test]
    public function current_price_can_be_updated(): void
    {
        $asset = AssetFactory::new()->create();
        $asset->updateCurrentPrice(
            Money::USD(20),
        );

        $this->assertEquals(20.0, $asset->fresh()->current_price->asFloat());
        $this->assertEquals(20.0, $asset->prices()->latest('id')->first()->price->asFloat());
    }
}
