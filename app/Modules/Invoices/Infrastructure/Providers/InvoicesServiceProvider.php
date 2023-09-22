<?php

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Api\InvoicesFacade;
use App\Modules\Invoices\Application\InvoicesFacadeInterface;
use App\Modules\Invoices\Application\InvoicesRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Repositories\InvoicesRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class InvoicesServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(InvoicesFacadeInterface::class, InvoicesFacade::class);
        $this->app->scoped(InvoicesRepositoryInterface::class, InvoicesRepository::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            InvoicesFacadeInterface::class,
            InvoicesRepositoryInterface::class
        ];
    }
}
