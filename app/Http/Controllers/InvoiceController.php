<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Invoices\Services\InvoiceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogicException;

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
        try {
            $this->invoiceService->approve($request->input('invoice_id'));

            return response()->json(['status' => 'Status approved set sucessfully'], 200);
        } catch (LogicException $e) {
            return response()->json(['error' => 'Failed to approve invoice: '.$e->getMessage()], 400);
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred: '.$e->getMessage()], 500);
        }
    }

    public function reject(Request $request): JsonResponse
    {
        try {
            $this->invoiceService->reject($request->input('invoice_id'));

            return response()->json(['status' => 'Status rejected set successfully']);
        } catch (LogicException $e) {
            return response()->json(['error' => 'Failed to reject invoice: '.$e->getMessage()], 400);
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred: '.$e->getMessage()], 500);
        }
    }
}
