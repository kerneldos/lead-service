<?php

namespace App\Providers;

use App\Services\Contracts\LeadProcessorInterface;
use App\Services\LeadProcessorService;
use Illuminate\Support\ServiceProvider;

class LeadProcessorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            LeadProcessorInterface::class,
            LeadProcessorService::class
        );
    }

    public function boot()
    {
        //
    }
}
