<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Services;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Entities\ApprovalInvoice as ApprovalInvoiceEntity;
use App\Modules\Invoices\Repositories\InvoiceRepository;
use LogicException;
use Ramsey\Uuid\Uuid;

class InvoiceService
{
    private InvoiceRepository $invoiceRepository;

    private ApprovalFacadeInterface $approvalFacade;

    public function __construct(InvoiceRepository $invoiceRepository, ApprovalFacadeInterface $approvalFacade)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->approvalFacade = $approvalFacade;
    }

    public function getAllInvoices(): array
    {
        return $this->invoiceRepository->findAll();
    }

    public function approve(string $invoiceId): void
    {
        $invoice = $this->invoiceRepository->findById(Uuid::fromString($invoiceId));
        if (! $invoice instanceof ApprovalInvoiceEntity) {
            throw new LogicException('Invoice must be an instance of ApprovalInvoiceEntity.');
        }

        $statusEnum = StatusEnum::fromString($invoice->getStatus());

        $dto = new ApprovalDto(Uuid::fromString($invoiceId), $statusEnum, 'invoice');
        $this->approvalFacade->approve($dto);

        $invoice->setStatus(StatusEnum::APPROVED->value);
        $this->invoiceRepository->save($invoice);
    }

    public function reject(string $invoiceId): void
    {
        $invoice = $this->invoiceRepository->findById(Uuid::fromString($invoiceId));
        if (! $invoice instanceof ApprovalInvoiceEntity) {
            throw new LogicException('Invoice must be an instance of ApprovalInvoiceEntity.');
        }

        $statusEnum = StatusEnum::fromString($invoice->getStatus());

        $dto = new ApprovalDto(Uuid::fromString($invoiceId), $statusEnum, 'invoice');
        $this->approvalFacade->reject($dto);

        $invoice->setStatus(StatusEnum::REJECTED->value);
        $this->invoiceRepository->save($invoice);
    }
}
