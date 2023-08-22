<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Http;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Application\Mapper\InvoiceMapper;
use App\Modules\Invoices\Application\Service\InvoiceService;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;

final class InvoiceController extends Controller
{
    public function __construct(
        private readonly InvoiceService $invoiceService
    ) {
    }

    public function show(string $id): JsonResponse
    {
        $invoice = $this->invoiceService->info(Uuid::fromString($id));

        return $this->jsonResponse(null, InvoiceMapper::fromDtoToArray($invoice));
    }

    public function approve(string $id): JsonResponse
    {
        $this->invoiceService->approve(Uuid::fromString($id));

        return $this->jsonResponse('Invoice has been approved successfully', null);
    }

    public function reject(string $id): JsonResponse
    {
        $this->invoiceService->reject(Uuid::fromString($id));

        return $this->jsonResponse('Invoice has been rejected successfully', null);
    }
}
