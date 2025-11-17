<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Key;
use Carbon\Carbon;

class DeactivateExpiredKeys extends Command
{
    protected $signature = 'keys:deactivate-expired';
    protected $description = 'Deactivate all active keys whose expire_date has passed';

    public function handle()
    {
        $now = Carbon::now();

        $expiredCount = Key::where('status', 'Active')
                          ->where('expire_date', '<', $now)
                          ->update(['status' => 'Inactive']);

        $this->info($expiredCount . ' key(s) set to Inactive.');
    }
}
