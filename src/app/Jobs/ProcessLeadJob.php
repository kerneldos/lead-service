<?php

namespace App\Jobs;

use App\Entities\Lead;
use App\Services\LeadProcessorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLeadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param Lead $lead
     */
    public function __construct(public Lead $lead)
    {
    }

    /**
     * @param LeadProcessorService $processor
     * @return void
     */
    public function handle(LeadProcessorService $processor)
    {
        $processor->process($this->lead);
    }
}
