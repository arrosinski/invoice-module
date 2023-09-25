<?php

namespace App\Modules\Invoices\Infrastructure\Repositories;

use App\Modules\Invoices\Application\InvoicesRepositoryInterface;
use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Domain\ValueObjects\StatusEnum;
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

    public function getStatus(string $id): string
    {
        return DB::table('invoices')
            ->select('invoices.status')
            ->where('invoices.id', $id)->first()->status;
    }

    public function reject(string $id)
    {
        return DB::table('invoices')
            ->where('invoices.id', $id)
            ->where('invoices.status', StatusEnum::DRAFT->value)
            ->update(['status' => StatusEnum::REJECTED->value]);
    }

    public function approve(string $id)
    {
        return DB::table('invoices')
            ->where('invoices.id', $id)
            ->where('invoices.status', StatusEnum::DRAFT->value)
            ->update(['status' => StatusEnum::APPROVED->value]);
    }
}
