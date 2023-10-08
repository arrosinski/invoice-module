<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\ValueObjects;

final class InvoiceTotalsVO
{
    public function __construct(
        public ?int $subtotalAmount = null,
        public ?int $salesTaxAmount = null,
    ) {
    }
}
