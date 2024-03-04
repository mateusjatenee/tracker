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
        /** @var \Modules\Exchange\Portfolio\Account $account */
        $account = $position->account;

        $account->buy($asset, 10, Money::USD(500));
    }

    #[Test]
    public function it_calculates_the_profit()
    {

    }
}
