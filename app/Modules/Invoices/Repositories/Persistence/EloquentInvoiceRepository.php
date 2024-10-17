<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Repositories\Persistence;

use App\Invoice as InvoiceModel;
use App\Modules\Invoices\Entities\Invoice as InvoiceEntity;
use App\Modules\Invoices\Repositories\InvoiceRepository;

class EloquentInvoiceRepository implements InvoiceRepository
{
    public function findAll(): array
    {
        $invoices = InvoiceModel::all(['number', 'date', 'due_date']);

        return $invoices->map(function ($invoice) {
            return new InvoiceEntity(
                $invoice->number,
                new \DateTime($invoice->date),
                new \DateTime($invoice->due_date)
            );
        })->toArray();
    }
}
