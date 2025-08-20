<?php

namespace App\Providers;

use App\Services\Contracts\LeadCompletenessCheckerInterface;
use App\Services\LeadCompletenessChecker;
use Illuminate\Support\ServiceProvider;

class LeadCompletenessCheckerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            LeadCompletenessCheckerInterface::class,
            LeadCompletenessChecker::class
        );
    }

    public function boot()
    {
        //
    }
}
