<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use Ramsey\Uuid\UuidInterface;

class InvoiceApproval
{
    public function __construct(
        public readonly UuidInterface $uuid,
        private StatusEnum $status,
    ) {
    }

    public function approve(ApprovalFacadeInterface $approvalFacade): void
    {
        $approvalFacade->approve(new ApprovalDto(
            $this->uuid,
            $this->status,
            Invoice::class,
        ));

        $this->status = StatusEnum::APPROVED;
    }

    public function reject(ApprovalFacadeInterface $approvalFacade): void
    {
        $approvalFacade->reject(new ApprovalDto(
            $this->uuid,
            $this->status,
            Invoice::class,
        ));

        $this->status = StatusEnum::REJECTED;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }
}
