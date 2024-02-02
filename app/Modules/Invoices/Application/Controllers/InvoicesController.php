<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Controllers;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Application\Exceptions\InvoiceNotFoundException;
use App\Modules\Invoices\Application\Responses\ShowInvoiceResponse;
use App\Modules\Invoices\Application\Services\InvoiceService;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvoicesController extends Controller
{
    public function __construct(
        private readonly InvoiceService $invoiceService,
    ) {
    }

    public function showAction(UuidInterface $uuid): Response
    {
        try {
            $invoice = $this->invoiceService->getInvoice($uuid);
        } catch (InvoiceNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        }

        return new ShowInvoiceResponse($invoice);
    }
}
