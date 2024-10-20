<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Invoices\Services\InvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

        return response()->json(array_map(function ($invoice) {
            return [
                'number' => $invoice->getNumber(),
                'date' => $invoice->getDate()->format('Y-m-d'),
                'dueDate' => $invoice->getDueDate()->format('Y-m-d'),
                'company' => [
                    'name' => $invoice->getCompany()->getName(),
                    'street' => $invoice->getCompany()->getStreet(),
                    'city' => $invoice->getCompany()->getCity(),
                    'zip' => $invoice->getCompany()->getZip(),
                    'phone' => $invoice->getCompany()->getPhone(),
                ],
                'billedCompany' => [
                    'name' => $invoice->getBilledCompany()->getName(),
                    'street' => $invoice->getBilledCompany()->getStreet(),
                    'city' => $invoice->getBilledCompany()->getCity(),
                    'zip' => $invoice->getBilledCompany()->getZip(),
                    'phone' => $invoice->getBilledCompany()->getPhone(),
                    'email' => $invoice->getBilledCompany()->getEmail(),
                ],
                'products' => array_map(function ($product) {
                    return [
                        'name' => $product->getName(),
                        'price' => $product->getPrice(),
                        'quantity' => $product->getQuantity(),
                        'total' => $product->getTotal(),
                    ];
                }, $invoice->getProducts()->getProducts()),
                'totalPrice' => $invoice->getTotalPrice(),
            ];
        }, $invoices));
    }

    public function approve(Request $request): JsonResponse
    {
        $this->invoiceService->approve($request->input('invoice_id'));
        return response()->json(['status' => 'approved']);
    }

    public function reject(Request $request): JsonResponse
    {
        $this->invoiceService->reject($request->input('invoice_id'));
        return response()->json(['status' => 'rejected']);
    }
}
