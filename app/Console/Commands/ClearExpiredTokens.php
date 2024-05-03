<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Http\Kernel;

class ClearExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear expired tokens';

    /**
     * Execute the console command.
     */
}
