<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Api\Dto\InvoiceResponseDto;
use App\Modules\Invoices\Api\InvoicesFacadeInterface;

class InvoicesFacade implements InvoicesFacadeInterface
{
    public function __construct(
        private readonly InvoicesFactory $invoicesFactory
    ) {
    }

    public function get(int $invoiceId): ?InvoiceDto
    {
        return $this->invoicesFactory->createInvoicesReader()->getInvoiceById($invoiceId);
    }

    public function approveInvoice(InvoiceDto $invoiceDto): InvoiceResponseDto
    {
        return $this->invoicesFactory->createInvoicesApprover()->approveInvoice($invoiceDto);
    }

    public function rejectInvoice(InvoiceDto $invoiceDto): InvoiceResponseDto
    {
        return $this->invoicesFactory->createInvoicesApprover()->rejectInvoice($invoiceDto);
    }
}
