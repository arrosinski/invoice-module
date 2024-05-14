<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Controllers;

use App\Domain\Enums\StatusEnum;
use App\Infrastructure\Controller;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Infrastructure\Model\Invoice as InvoiceModel;

final class InvoiceApprovalController extends Controller
{
    public function __construct(
        private readonly ApprovalFacadeInterface $approvalFacade
    ) {
    }

    public function __invoke(InvoiceModel $invoice, InvoiceApprovalRequest $request): void
    {
        $dto = new ApprovalDto(
            $invoice->id,
            StatusEnum::DRAFT,
            Invoice::class
        );

        switch (StatusEnum::tryFrom($request->status)) {
            case StatusEnum::APPROVED:
                $this->approvalFacade->approve($dto);
                break;
            case StatusEnum::REJECTED:
                $this->approvalFacade->reject($dto);
                break;
        }
    }
}
