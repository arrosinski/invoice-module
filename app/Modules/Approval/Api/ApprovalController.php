<?php

namespace App\Modules\Approval\Api;

use App\Domain\Enums\StatusEnum;
use App\Infrastructure\Controller;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Domain\Invoice;
use Ramsey\Uuid\Uuid;

class ApprovalController extends Controller
{
    public function __construct(
        private IdempotentApprovalFacade $facade
    ) {
    }
    public function approve(Uuid $id): int|bool
    {
        $result = $this->facade->approve(new ApprovalDto($id, StatusEnum::APPROVED, Invoice::class));
        return http_response_code($result ? 200 : 400);
    }

    public function reject(Uuid $id): int|bool
    {
        $result = $this->facade->reject(new ApprovalDto($id, StatusEnum::REJECTED, Invoice::class));
        return http_response_code($result ? 200 : 400);
    }

}
