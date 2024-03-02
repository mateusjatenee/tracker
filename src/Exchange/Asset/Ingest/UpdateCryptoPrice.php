<?php

declare(strict_types=1);

namespace Modules\Exchange\Asset\Ingest;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Exchange\Asset\Asset;

class UpdateCryptoPrice implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Asset $asset,
    ) {
    }

    public function handle(CryptoAssetInformationProvider $provider): void
    {
        $coinInformation = $provider->fetchCoinPrice($this->asset->ticker);

        $this->asset->updateCurrentPrice($coinInformation->price);
    }
}
