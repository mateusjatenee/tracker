<?php

declare(strict_types=1);

namespace Modules\Exchange\Asset\Ingest;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Money\Money;

class CoinbaseAssetInformationProvider implements CryptoAssetInformationProvider
{
    public function fetchCoinPrice(string $ticker): CryptoCoin
    {
        $price = $this->client()->get("prices/{$ticker}-USD/buy")->json('data');

        return new CryptoCoin(
            ticker: $ticker,
            price: Money::USD((int) ($price['amount'] * 100))
        );
    }

    public function client(): PendingRequest
    {
        return Http::baseUrl('https://api.coinbase.com/v2');
    }
}
