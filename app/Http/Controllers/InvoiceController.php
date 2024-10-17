<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Services\InvoiceService;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    private InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index(): JsonResponse
    {
        $invoices = $this->invoiceService->getAllInvoices();
        return response()->json($invoices);
    }
}
