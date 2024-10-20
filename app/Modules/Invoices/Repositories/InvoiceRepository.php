<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Repositories;

use App\Modules\Invoices\Entities\Invoice;

interface InvoiceRepository
{
    public function findAll(): array;
    public function save(Invoice $invoice): void;
}
