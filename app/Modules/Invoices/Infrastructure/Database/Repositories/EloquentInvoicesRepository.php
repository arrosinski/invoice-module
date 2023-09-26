<?php

namespace App\Modules\Invoices\Infrastructure\Database\Repositories;

use App\Modules\Invoices\Application\InvoicesRepositoryInterface;
use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Domain\ValueObjects\StatusEnum;
use App\Modules\Invoices\Infrastructure\Database\Dao\InvoiceDao;
use App\Modules\Invoices\Infrastructure\Mapper\InvoiceMapper;

class EloquentInvoicesRepository implements InvoicesRepositoryInterface
{

    public function get(string $id): Invoice
    {
        $invoice = InvoiceDao::with(['company', 'lineItems'])->where('id', $id)->first();

        return InvoiceMapper::map($invoice);
    }

    public function getAll(): array
    {
        return InvoiceDao::all()->map(function ($invoice) {
            return Invoice::builder()
                ->fromArray($invoice->toArray())
                ->withDueDate($invoice['due_date'])
                ->withCreatedAt($invoice['created_at'])
                ->withUpdatedAt($invoice['updated_at'])
                ->build();
        })->toArray();
    }

    public function reject(string $id)
    {
        $invoice = InvoiceDao::find($id);
        $invoice->status = StatusEnum::REJECTED->value;
        $invoice->save();
    }

    public function approve(string $id)
    {
        $invoice = InvoiceDao::find($id);
        $invoice->status = StatusEnum::APPROVED->value;
        $invoice->save();
    }

}
