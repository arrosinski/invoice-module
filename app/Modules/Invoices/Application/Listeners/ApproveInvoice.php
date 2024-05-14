<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Listeners;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Invoices\Application\InvoiceRepositoryInterface;
use App\Modules\Invoices\Domain\Invoice;

final readonly class ApproveInvoice
{
    public function __construct(
        private InvoiceRepositoryInterface $repository
    ) {
    }

    public function __invoke(EntityApproved $event): void
    {
        $dto = $event->approvalDto;
        if (Invoice::class !== $dto->entity) {
            return;
        }

        $invoice = $this->repository->get($dto->id);
        $invoice->approve();
        $this->repository->save($invoice);
    }
}