<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Service;

use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Application\Exception\InvoiceNotFoundException;
use App\Modules\Invoices\Application\Mapper\InvoiceMapper;
use App\Modules\Invoices\Domain\Entity\Invoice;
use App\Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class InvoiceService
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository,
        private ApprovalFacadeInterface $approvalService,
    ) {
    }

    /**
     * @throws InvoiceNotFoundException
     * @throws \Exception
     */
    public function info(UuidInterface $id): InvoiceDto
    {
        $invoice = $this->fetchById($id);

        return InvoiceMapper::fromEntityToDto($invoice);
    }

    /**
     * @throws InvoiceNotFoundException
     * @throws \LogicException
     */
    public function approve(UuidInterface $id): void
    {
        $invoice = $this->fetchById($id);

        $approval = new ApprovalDto($invoice->getId(), $invoice->getStatus(), Invoice::class);

        $this->approvalService->approve($approval);

        $invoice->approve();

        $this->invoiceRepository->update($invoice);
    }

    /**
     * @throws InvoiceNotFoundException
     * @throws \LogicException
     */
    public function reject(UuidInterface $id): void
    {
        $invoice = $this->fetchById($id);

        $approval = new ApprovalDto($invoice->getId(), $invoice->getStatus(), Invoice::class);

        $this->approvalService->reject($approval);

        $invoice->reject();

        $this->invoiceRepository->update($invoice);
    }

    /**
     * @throws InvoiceNotFoundException
     */
    private function fetchById(UuidInterface $id): Invoice
    {
        $invoice = $this->invoiceRepository->findById($id);

        if (null === $invoice) {
            throw new InvoiceNotFoundException('Approval cannot be performed because the invoice could not be found');
        }

        return $invoice;
    }
}
