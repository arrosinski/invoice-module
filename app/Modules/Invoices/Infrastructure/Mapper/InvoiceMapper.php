<?php

namespace App\Modules\Invoices\Infrastructure\Mapper;

use App\Modules\Invoices\Domain\Entities\Company;
use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Domain\Entities\LineItem;
use App\Modules\Invoices\Infrastructure\Database\Dao\InvoiceDao;
use stdClass;

class InvoiceMapper
{
    public static function map(stdClass|InvoiceDao $invoice): Invoice
    {
        $lineItems = [];
        $grandTotal = 0;

        if (isset($invoice->lineItems)) {
            foreach ($invoice->lineItems as $lineItem) {
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
                $grandTotal += $lineItem->price * $lineItem->quantity;
            }
        }

        return Invoice::builder()
            ->withId($invoice->id)
            ->withStatus(is_string($invoice->status) ? $invoice->status : $invoice->status->value)
            ->withCompany(
                Company::builder()
                    ->fromArray($invoice->company->toArray())
                    ->withCreatedAt($invoice->company->created_at)
                    ->withUpdatedAt($invoice->company->updated_at)
                    ->build()
            )
            ->withDueDate($invoice->due_date)
            ->withCreatedAt($invoice->created_at)
            ->withUpdatedAt($invoice->updated_at)
            ->withLineItems($lineItems)
            ->withGrandTotal($grandTotal)
            ->build();

    }
}
