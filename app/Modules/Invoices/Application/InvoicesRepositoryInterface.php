<?php

namespace App\Modules\Invoices\Application;

use App\Modules\Invoices\Domain\Invoice;

interface InvoicesRepositoryInterface
{
    public function get(string $id): Invoice;
    public function getAll(): array;
}
