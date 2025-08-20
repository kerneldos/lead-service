<?php

namespace App\Listeners;

use App\Events\LeadProcessed;
use App\Services\NotificationService;

class SendLeadNotification
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    public function handle(LeadProcessed $event): void
    {
        $this->notificationService->send(
            'New processed lead: ' . $event->lead->id,
            'leads-channel'
        );
    }
}
