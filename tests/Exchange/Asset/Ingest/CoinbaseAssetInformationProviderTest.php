<?php

namespace Tests\Exchange\Asset\Ingest;

use Modules\Exchange\Asset\Ingest\CoinbaseAssetInformationProvider;
use Money\Money;
use Tests\TestCase;

class CoinbaseAssetInformationProviderTest extends TestCase
{
    public function testFetchCoinPrice(): void
    {
        $coin = app(CoinbaseAssetInformationProvider::class)->fetchCoinPrice('ETH');

        $this->assertInstanceOf(Money::class, $coin->price);
    }
}
