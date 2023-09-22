<?php

namespace App\Modules\Invoices\Api;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Application\InvoicesFacadeInterface;

class InvoiceController extends Controller
{
    private InvoicesFacadeInterface $invoicesFacade;

    public function __construct(InvoicesFacadeInterface $invoicesFacade)
    {
        $this->invoicesFacade = $invoicesFacade;
    }

    public function index()
    {
        return response()->json($this->invoicesFacade->list());
    }

    public function show(string $id)
    {
        return response()->json(
            $this->invoicesFacade->get($id)
        );
    }
}
