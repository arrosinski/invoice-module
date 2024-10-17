<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers;

use App\Modules\Invoices\Repositories\InvoiceRepository;
use App\Modules\Invoices\Repositories\Persistence\EloquentInvoiceRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     */
    public function register(): void
    {
        $this->app->bind(InvoiceRepository::class, EloquentInvoiceRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     */
    public function boot(): void
    {
        //
    }
}
