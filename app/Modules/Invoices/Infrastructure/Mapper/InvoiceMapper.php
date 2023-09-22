<?php

namespace App\Modules\Invoices\Infrastructure\Mapper;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Company;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\LineItem;

class InvoiceMapper
{
    public static function map(\stdClass $invoice): Invoice
    {
        $lineItems = [];
        foreach ($invoice->line_items as $lineItem) {
            $lineItems[] = new LineItem(
                $lineItem->id,
                $lineItem->name,
                $lineItem->quantity,
                $lineItem->price,
                $lineItem->price * $lineItem->quantity,
                $lineItem->currency,
                $lineItem->created_at,
                $lineItem->updated_at
            );
        }

        return new Invoice(
            $invoice->id,
            $invoice->number,
            $invoice->date,
            $invoice->due_date,
            StatusEnum::from($invoice->status),
            new Company(
                $invoice->company->id,
                $invoice->company->name,
                $invoice->company->street,
                $invoice->company->city,
                $invoice->company->zip,
                $invoice->company->phone,
                $invoice->company->email,
                $invoice->company->created_at,
                $invoice->company->updated_at
            ),
            $lineItems,
            $invoice->created_at,
            $invoice->updated_at
        );
    }
}
