<?php

namespace App\Modules\Invoices\Application;

use App\Modules\Invoices\Domain\Entities\Invoice;

interface InvoicesRepositoryInterface
{
    public function get(string $id): Invoice;
    public function getAll(): array;
    public function reject(string $id);
    public function approve(string $id);
}
