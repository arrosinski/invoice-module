<?php

namespace App\Modules\Invoices\Application;

use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;
use App\Modules\Approval\Application\ApprovalFacade;
use App\Modules\Invoices\Exceptions\InvoiceNotFoundException;
use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Dto\ApprovalDto;

class InvoiceService
{
    protected $invoiceRepository;
    protected $approvalService;
    
    public function __construct(InvoiceRepositoryInterface $invoiceRepository, ApprovalFacade $approvalService)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->approvalService = $approvalService;
    }

    public function getInvoice(string $id): Invoice
    {
        $invoice = $this->invoiceRepository->getById($id);

        if (!$invoice) {
            throw new InvoiceNotFoundException();
        }

        return $invoice;
    }

    public function approveInvoice(string $id): Invoice
    {
        $invoice = $this->getInvoice($id);
        $this->approvalService->approve(new ApprovalDto($invoice->getNumber(), $invoice->getStatus(), 'invoice'));
        $invoice->setStatus(StatusEnum::APPROVED);

        $this->invoiceRepository->update($invoice);

        return $invoice;
    }

    public function rejectInvoice(string $id): Invoice
    {
        $invoice = $this->getInvoice($id);
        $this->approvalService->reject(new ApprovalDto($invoice->getNumber(), $invoice->getStatus(), 'invoice'));

        $invoice->setStatus(StatusEnum::REJECTED);
        $this->invoiceRepository->update($invoice);

        return $invoice;
    }
}
