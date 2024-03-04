<?php

namespace Tests\Exchange\Portfolio;

use Event;
use Modules\Exchange\database\factories\AccountFactory;
use Modules\Exchange\database\factories\AssetFactory;
use Money\Money;
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
            quantity: 10,
            totalPaid: Money::USD(500),
        );

        $this->assertEquals(1, $account->transactions()->count());

        $account->sell(
            asset: $asset,
            quantity: 5,
            totalPaid: Money::USD(1500),
        );

        $this->assertEquals(2, $account->transactions()->count());
    }
}
