<?php

namespace App\Modules\Approval\Api;

use App\Infrastructure\Controller;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Domain\ValueObjects\StatusEnum;
use Illuminate\Http\JsonResponse;

class InvoiceApprovalController extends Controller
{
    public function __construct(
        private ApprovalFacade $facade
    ) {
    }
    public function approve(string $id): JsonResponse
    {
        $this->facade->approve(new ApprovalDto($id, StatusEnum::APPROVED, Invoice::class));
        return response()->json(['message' => 'Invoice approved']);
    }

    public function reject(string $id): JsonResponse
    {
        $this->facade->reject(new ApprovalDto($id, StatusEnum::REJECTED, Invoice::class));
        return response()->json(['message' => 'Invoice rejected']);
    }

}
