<?php

declare(strict_types=1);

namespace Modules\Exchange\Asset;

enum AssetType: string
{
    case Stock = 'stock';

    case Crypto = 'crypto';
}
