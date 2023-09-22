<?php

namespace App\Modules\Invoices\Application;

use App\Modules\Invoices\Domain\Invoice;

interface InvoicesFacadeInterface
{
    public function list(): array;

    public function get(string $id): Invoice;
}
