<?php

namespace Modules\Exchange\Asset\Ingest;

use Illuminate\Console\Command;
use Modules\Exchange\Asset\Asset;

class RefreshCryptoPricesCommand extends Command
{
    protected $signature = 'refresh:crypto-prices';

    protected $description = 'Command description';

    protected bool $shouldKeepRunning = true;

    public function handle(): void
    {
        $this->trap(SIGTERM, fn () => $this->shouldKeepRunning = false);

        while ($this->shouldKeepRunning) {
            $this->info('Refreshing crypto prices...');

            Asset::query()
                ->crypto()
                ->get()
                ->each(fn (Asset $asset) => dispatch(new UpdateCryptoPrice($asset)));

            $this->info('Refreshed crypto prices. Waiting 20 seconds...');
            sleep(20);
        }
    }
}
