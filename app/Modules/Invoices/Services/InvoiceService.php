<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Services;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Repositories\InvoiceRepository;
use Illuminate\Http\JsonResponse;
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

    public function approve(string $invoiceId): JsonResponse
    {
        try {
            $invoice = $this->invoiceRepository->findById(Uuid::fromString($invoiceId));
            $statusEnum = StatusEnum::fromString($invoice->getStatus());

            $dto = new ApprovalDto(Uuid::fromString($invoiceId), $statusEnum, 'invoice');
            $this->approvalFacade->approve($dto);

            $invoice->setStatus(StatusEnum::APPROVED->value);
            $this->invoiceRepository->save($invoice);

            return response()->json(['message' => 'Invoice approved successfully.']);
        } catch (LogicException $e) {
            return response()->json(['error' => 'Failed to approve invoice: '.$e->getMessage()], 400);
        }
    }

    public function reject(string $invoiceId): JsonResponse
    {
        try {
            $invoice = $this->invoiceRepository->findById(Uuid::fromString($invoiceId));
            $statusEnum = StatusEnum::fromString($invoice->getStatus());

            $dto = new ApprovalDto(Uuid::fromString($invoiceId), $statusEnum, 'invoice');
            $this->approvalFacade->reject($dto);

            $invoice->setStatus(StatusEnum::REJECTED->value);
            $this->invoiceRepository->save($invoice);

            return response()->json(['message' => 'Invoice rejected successfully.']);
        } catch (LogicException $e) {
            return response()->json(['error' => 'Failed to reject invoice: '.$e->getMessage()], 400);
        }
    }
}
