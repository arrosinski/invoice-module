<?php

namespace App\Modules\Invoices\Application\Http\Controllers;

use App\Modules\Invoices\Application\InvoiceService;
use App\Infrastructure\Controller;
use App\Modules\Invoices\Application\Http\Requests\InvoiceRequest;
use App\Modules\Invoices\Exceptions\InvoiceNotFoundException;
use App\Modules\Invoices\Application\Mapper\InvoiceMapper;
use Illuminate\Http\Response;
use LogicException;

class InvoiceController extends Controller
{
    private $invoiceService;
    private $invoiceMapper;

    public function __construct(InvoiceService $invoiceService, InvoiceMapper $invoiceMapper)
    {
        $this->invoiceService = $invoiceService;
        $this->invoiceMapper = $invoiceMapper;
    }

    public function show(InvoiceRequest $request)
    {
        $data = $request->validated();
        $invoice = $this->invoiceService->getInvoice($data['uuid']);
        if (!$invoice) {
            throw new InvoiceNotFoundException();
        }

        $invoiceDTO = $this->invoiceMapper->toDTO($invoice);
        return response()->json($invoiceDTO->jsonSerialize(), Response::HTTP_OK);
    }

    public function approve(InvoiceRequest $request)
    {
        $data = $request->validated();
        try {
            //code...
            $this->invoiceService->approveInvoice($data['uuid']);
        } catch (LogicException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => 'The invoice was approved'], Response::HTTP_OK);
    }

    public function reject(InvoiceRequest $request)
    {
        $data = $request->validated();
        try {
            //code...
            $this->invoiceService->rejectInvoice($data['uuid']);
        } catch (LogicException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => 'Invoice rejected.'], Response::HTTP_OK);
    }

}
