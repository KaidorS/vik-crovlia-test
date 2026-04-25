<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\ReportPolicy;
use App\Models\Report;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Report::class => ReportPolicy::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
