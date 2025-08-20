<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LeadProcessorService;

class ProcessLeadsCommand extends Command
{
    protected $signature = 'leads:process';
    protected $description = 'Process pending leads';

    public function handle(LeadProcessorService $processor): void
    {
        $count = $processor->processPendingLeads();
        $this->info("Processed $count leads");
    }
}
