<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\LeadRepositoryInterface;
use App\Repositories\EloquentLeadRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            LeadRepositoryInterface::class,
            EloquentLeadRepository::class
        );
    }

    public function boot()
    {
        //
    }
}
