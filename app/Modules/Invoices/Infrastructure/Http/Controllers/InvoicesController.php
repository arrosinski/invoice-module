<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Controllers;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Api\InvoicesFacadeInterface;
use App\Modules\Invoices\Infrastructure\Http\Resources\InvoiceResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoicesController extends Controller
{
    public function getInvoiceAction(int $id, InvoicesFacadeInterface $invoicesFacade): JsonResponse|JsonResource
    {
        $invoiceDto = $invoicesFacade->get($id);
        if (null === $invoiceDto) {
            return $this->notFoundResponse();
        }

        return $this->resourceResponse(InvoiceResource::make($invoiceDto));
    }

    public function approveInvoiceAction(int $id, InvoicesFacadeInterface $invoicesFacade): JsonResponse|JsonResource
    {
        $invoiceDtoResponse = $invoicesFacade->approveInvoice((new InvoiceDto(id: $id)));
        if (!$invoiceDtoResponse->isSuccess) {
            return $this->errorResponse($invoiceDtoResponse->errors[0]->message);
        }

        return $this->resourceResponse(InvoiceResource::make($invoiceDtoResponse->invoiceDto));
    }


    public function rejectInvoiceAction(int $id, InvoicesFacadeInterface $invoicesFacade): JsonResponse|JsonResource
    {
        $invoiceDtoResponse = $invoicesFacade->rejectInvoice((new InvoiceDto(id: $id)));
        if (!$invoiceDtoResponse->isSuccess) {
            return $this->errorResponse($invoiceDtoResponse->errors[0]->message);
        }

        return $this->resourceResponse(InvoiceResource::make($invoiceDtoResponse->invoiceDto));
    }
}
