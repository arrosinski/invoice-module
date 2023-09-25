<?php

namespace App\Modules\Invoices\Infrastructure\Providers;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Infrastructure\Listeners\InvoiceApprovedListener;
use App\Modules\Invoices\Infrastructure\Listeners\InvoiceRejectedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class InvoicesEventsServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        EntityApproved::class => [
            InvoiceApprovedListener::class
        ],
        EntityRejected::class => [
            InvoiceRejectedListener::class
        ],
    ];

    public function boot(): void
    {
        //
    }


    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
