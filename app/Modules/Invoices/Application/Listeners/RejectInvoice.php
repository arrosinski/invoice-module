<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Listeners;

use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Application\InvoiceRepositoryInterface;
use App\Modules\Invoices\Domain\Invoice;

final readonly class RejectInvoice
{
    public function __construct(
        private InvoiceRepositoryInterface $repository
    ) {
    }

    public function __invoke(EntityRejected $event): void
    {
        $dto = $event->approvalDto;
        if (Invoice::class !== $dto->entity) {
            return;
        }

        $invoice = $this->repository->get($dto->id);
        $invoice->reject();
        $this->repository->save($invoice);
    }
}
