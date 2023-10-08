<?php

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Invoices\Api\InvoicesFacadeInterface;
use App\Modules\Invoices\Application\InvoicesFacade;
use App\Modules\Invoices\Application\Repository\InvoicesRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Database\InvoicesEloquentRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class InvoicesServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(InvoicesFacadeInterface::class, InvoicesFacade::class);
        $this->app->scoped(InvoicesRepositoryInterface::class, InvoicesEloquentRepository::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            ApprovalFacadeInterface::class,
            InvoicesRepositoryInterface::class,
        ];
    }
}
