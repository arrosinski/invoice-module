<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Domain\Repositories\InvoiceApprovalRepository as InvoiceApprovalRepositoryContract;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepository as InvoiceRepositoryContract;
use App\Modules\Invoices\Infrastructure\Repositories\InvoiceApprovalRepository;
use App\Modules\Invoices\Infrastructure\Repositories\InvoiceRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class InvoicesServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(InvoiceApprovalRepositoryContract::class, InvoiceApprovalRepository::class);
        $this->app->scoped(InvoiceRepositoryContract::class, InvoiceRepository::class);
    }

    /**
     * @return array<class-string>
     */
    public function provides(): array
    {
        return [
            InvoiceApprovalRepositoryContract::class,
            InvoiceRepositoryContract::class,
        ];
    }
}
