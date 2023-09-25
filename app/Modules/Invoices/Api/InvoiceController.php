<?php

namespace App\Modules\Invoices\Api;

use App\Infrastructure\Controller;
use App\Infrastructure\HateoasResponse;
use App\Modules\Invoices\Api\Dto\InvoicesLinks;
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
        // Can be extended to include pagination
        return HateoasResponse::create(
                InvoicesLinks::parse_list_links($this->invoicesFacade->list()),
                InvoicesLinks::index_links())
            ->toResponse();
    }

    public function show(string $id)
    {
        $invoice = $this->invoicesFacade->get($id);
        return HateoasResponse::create(
            $invoice,
            InvoicesLinks::show_links($id, $invoice->canApprove())
        )->toResponse();
    }

}
