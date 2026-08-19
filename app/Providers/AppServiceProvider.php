<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ── Lead Module Repository Bindings ──────────────────────────────────
        $this->app->bind(
            \App\Repositories\Lead\Interfaces\LeadUserRepositoryInterface::class,
            \App\Repositories\Lead\LeadUserRepository::class
        );
        $this->app->bind(
            \App\Repositories\Lead\Interfaces\LeadCustomerRepositoryInterface::class,
            \App\Repositories\Lead\LeadCustomerRepository::class
        );
        $this->app->bind(
            \App\Repositories\Lead\Interfaces\LeadCustomerTimelineRepositoryInterface::class,
            \App\Repositories\Lead\LeadCustomerTimelineRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
