<?php

namespace App\Modules\Invoices\Domain\Repositories;

use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Domain\Enums\StatusEnum;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use stdClass;

class EloquentInvoiceRepository implements InvoiceRepositoryInterface
{

    public function update(Invoice $invoice): void
    {
        DB::table('invoices')->update([
            'status' => $invoice->getStatus(),
        ]);
    }

    public function getById(string $id): ?Invoice
    {
        $invoice = DB::table('invoices')->where('id', $id)->first();

        if (!$invoice) {
            return null;
        }

        return new Invoice(
            $invoice->id,
            Uuid::fromString($invoice->number),
            $invoice->date,
            $invoice->due_date,
            $this->getCompany($invoice->company_id),
            StatusEnum::from($invoice->status),
            $this->getItems($invoice->id)
        );
    }

    public function approve(string $id): ?Invoice
    {
        $invoice = DB::table('invoices')->where('id', $id)->first();

        if (!$invoice) {
            return null;
        }

        $invoice->status = StatusEnum::APPROVED;
        $invoice->save();

        return $invoice;
    }

    public function reject(string $id): ?Invoice
    {
        $invoice = DB::table('invoices')->where('id', $id)->first();

        if (!$invoice) {
            return null;
        }

        $invoice->status = StatusEnum::REJECTED;
        $invoice->save();

        return $invoice;
    }

    public function getCompany(string $companyId): stdClass
    {
        $company = DB::table('companies')->where('id', $companyId)->first();

        return $company;
    }

    public function getItems(string $invoiceId): Collection
    {
        $items = DB::table('invoice_product_lines')
        ->select('*')
        ->join('products', 'product_id', '=', 'products.id')
        ->where('invoice_id', $invoiceId)->get();

        return $items;
    }
}
