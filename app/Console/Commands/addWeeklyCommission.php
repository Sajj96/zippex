<?php

namespace App\Console\Commands;

use App\Models\Revenue;
use Illuminate\Console\Command;

class addWeeklyCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-weekly-commission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Revenue::referralCommission();
        Revenue::transactionCommission();
    }
}
