<?php

namespace App\Console\Commands;

use App\Enums\ConnectionStatus;
use App\Models\ConnectionRequest;
use Illuminate\Console\Command;

class CleanupOldConnectionRequests extends Command
{
    protected $signature = 'app:connection:cleanup-old';

    protected $description = 'Remove sent connection requests that are older than 24 hours and not accepted or rejected';

    public function handle(): int
    {
        $cutoffTime = now()->subDay();

        ConnectionRequest::where('status', ConnectionStatus::Pending)
            ->where('created_at', '<', $cutoffTime)
            ->delete();

        return self::SUCCESS;
    }
}
