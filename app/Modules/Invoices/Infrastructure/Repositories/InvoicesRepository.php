<?php

namespace App\Modules\Invoices\Infrastructure\Repositories;

use App\Modules\Invoices\Application\InvoicesRepositoryInterface;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Infrastructure\Mapper\InvoiceMapper;
use Illuminate\Support\Facades\DB;

final class InvoicesRepository implements InvoicesRepositoryInterface
{
    public function get(string $id): Invoice
    {
        $invoice = DB::table('invoices')
            ->where('invoices.id', $id)->first();
        $invoice->line_items = DB::table('invoice_product_lines')->where('invoice_id', $id)
            ->join('products', 'invoice_product_lines.product_id', '=', 'products.id')
            ->get()->toArray();
        $invoice->company = DB::table('companies')
            ->where('companies.id', $invoice->company_id)->first();
        return InvoiceMapper::map($invoice);
    }

    public function getAll(): array
    {
        return DB::table('invoices')->get()->toArray();
    }
}
