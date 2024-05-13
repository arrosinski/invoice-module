<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Listeners;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Application\InvoiceRepositoryInterface;
use App\Modules\Invoices\Domain\Invoice;
use Illuminate\Events\Dispatcher;

final readonly class InvoiceEventSubscriber
{
    public function __construct(
        private InvoiceRepositoryInterface $repository
    ) {
    }

    public function approveInvoice(EntityApproved $event): void
    {
        $dto = $event->approvalDto;
        if (Invoice::class !== $dto->entity) {
            return;
        }

        $invoice = $this->repository->get($dto->id);
        $invoice->approve();
        $this->repository->save($invoice);
    }

    public function rejectInvoice(EntityRejected $event): void
    {
        $dto = $event->approvalDto;
        if (Invoice::class !== $dto->entity) {
            return;
        }

        $invoice = $this->repository->get($dto->id);
        $invoice->reject();
        $this->repository->save($invoice);
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            EntityApproved::class =>  'approveInvoice',
            EntityRejected::class => 'rejectInvoice',
        ];
    }
}
