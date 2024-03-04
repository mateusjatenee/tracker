<?php

declare(strict_types=1);

namespace Modules\Exchange\Portfolio;

enum AccountType: string
{
    case Crypto = 'crypto';
    case Stock = 'stock';
}
