<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Approver;

use App\Domain\ErrorDto;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Api\Dto\InvoiceResponseDto;
use App\Modules\Invoices\Application\Repository\InvoicesRepositoryInterface;
use App\Modules\Invoices\Domain\Invoice;

class InvoicesApprover
{
    public function __construct(
        private readonly ApprovalFacadeInterface $approvalFacade,
        private readonly InvoicesRepositoryInterface $invoicesRepository,
    ) {
    }

    public function approveInvoice(InvoiceDto $invoiceDto): InvoiceResponseDto
    {
        $invoiceDto = $this->invoicesRepository->get($invoiceDto->id);

        $invoice = new Invoice(
            status: $invoiceDto->status
        );

        $invoiceResponseDto = new InvoiceResponseDto(
            invoiceDto: $invoiceDto,
            isSuccess: true,
        );

        try {
            $invoice->approve();
        } catch (\LogicException $exception) {
            $invoiceResponseDto->isSuccess = false;
            $invoiceResponseDto->errors[] = new ErrorDto($exception->getMessage());

            return $invoiceResponseDto;
        }

        //@todo map invoiceDto to approvalDto and call
        $this->approvalFacade->approve(new ApprovalDto());
        $this->invoicesRepository->update($invoiceDto);

        return $invoiceResponseDto;
    }

    public function rejectInvoice(InvoiceDto $invoiceDto): InvoiceResponseDto
    {
        //@todo same as approve but reversed logic
        return new InvoiceResponseDto(
            invoiceDto: $invoiceDto,
            isSuccess: true,
        );
    }
}
