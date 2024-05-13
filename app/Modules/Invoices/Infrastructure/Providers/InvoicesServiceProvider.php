<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Application\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Listeners\InvoiceEventSubscriber;
use App\Modules\Invoices\Infrastructure\Repositories\EloquentInvoiceRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class InvoicesServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/api.php');

        Event::subscribe(InvoiceEventSubscriber::class);
    }

    public function register(): void
    {
        $this->app->scoped(InvoiceRepositoryInterface::class, EloquentInvoiceRepository::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            InvoiceRepositoryInterface::class,
        ];
    }
}
