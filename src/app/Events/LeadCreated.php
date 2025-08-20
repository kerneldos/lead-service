<?php

namespace App\Events;

use App\Entities\Lead;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param Lead $lead
     */
    public function __construct(public Lead $lead)
    {
    }
}
