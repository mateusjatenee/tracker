<?php

declare(strict_types=1);

namespace Modules\Exchange\Asset\Ingest;

interface CryptoAssetInformationProvider
{
    public function fetchCoinPrice(string $ticker): CryptoCoin;
}
