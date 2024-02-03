<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Services;

use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Invoices\Application\Exceptions\InvoiceNotFoundException;
use App\Modules\Invoices\Domain\Models\InvoiceApproval;
use App\Modules\Invoices\Domain\Repositories\InvoiceApprovalRepository;
use Illuminate\Database\ConnectionInterface;
use Ramsey\Uuid\UuidInterface;
use Throwable;

readonly class ApprovalService
{
    public function __construct(
        private ConnectionInterface $db,
        private InvoiceApprovalRepository $invoiceApprovalRepository,
        private ApprovalFacadeInterface $approvalFacade,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function approve(UuidInterface $uuid): void
    {
        $invoice = $this->getInvoiceApproval($uuid);
        $this->db->transaction(function () use ($invoice): void {
            $invoice->approve($this->approvalFacade);

            $this->invoiceApprovalRepository->update($invoice);
        });
    }

    /**
     * @throws Throwable
     */
    public function reject(UuidInterface $uuid): void
    {
        $invoice = $this->getInvoiceApproval($uuid);
        $this->db->transaction(function () use ($invoice): void {
            $invoice->reject($this->approvalFacade);

            $this->invoiceApprovalRepository->update($invoice);
        });
    }

    private function getInvoiceApproval(UuidInterface $uuid): InvoiceApproval
    {
        return $this->invoiceApprovalRepository->findById($uuid) ?? throw new InvoiceNotFoundException($uuid);
    }
}
