<?php

namespace Tests\Exchange\Portfolio;

use Event;
use Modules\Exchange\database\factories\AccountFactory;
use Modules\Exchange\database\factories\AssetFactory;
use Modules\Exchange\Money;
use Modules\Exchange\Quantity;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountTest extends TestCase
{
    #[Test]
    public function it_adds_a_transaction_to_an_account(): void
    {
        Event::fake();

        $asset = AssetFactory::new()->create([
            'current_price' => Money::USD(1000),
        ]);
        $account = AccountFactory::new()->stock()->create();

        $account->buy(
            asset: $asset,
            quantity: Quantity::make(10),
            amountPaidPerUnit: Money::USD(5.0),
        );

        $this->assertEquals(1, $account->transactions()->count());

        $account->sell(
            asset: $asset,
            quantity: Quantity::make(5),
            amountPaidPerUnit: Money::USD(15.0),
        );

        $this->assertEquals(2, $account->transactions()->count());
        $this->assertEquals(1, $account->positions()->count());
    }

    #[Test]
    public function it_finds_or_creates_a_position_for_a_given_asset(): void
    {
        $asset = AssetFactory::new()->stock()->create();
        $account = AccountFactory::new()->stock()->create();

        $this->assertEquals(0, $account->positions()->count());

        $position = $account->fetchPositionForAsset($asset);

        $this->assertEquals(1, $account->positions()->count());
        $this->assertEquals($position->id, $position->id);

        $account->fetchPositionForAsset($asset);
        $this->assertEquals(1, $account->positions()->count());
    }
}
