<?php

declare(strict_types=1);

namespace Modules\Exchange\Asset\Ingest;

use Money\Currency;
use Money\Money;

readonly class CryptoCoin
{
    public Currency $currency;

    public function __construct(
        public string $ticker,
        public Money $price,
    ) {
        $this->currency = new Currency('USD');
    }
}
