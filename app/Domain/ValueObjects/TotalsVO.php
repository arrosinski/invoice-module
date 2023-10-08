<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

final class TotalsVO
{
    public function __construct(
        public ?int $subtotalAmount = null,
        public ?int $salesTaxAmount = null,
    ) {
    }
}
