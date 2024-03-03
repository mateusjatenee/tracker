<?php

declare(strict_types=1);

namespace Modules\Exchange\Portfolio;

enum TransactionType: string
{
    case Buy = 'buy';
    case Sell = 'sell';
}
