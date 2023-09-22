<?php

namespace App\Modules\Invoices\Infrastructure\Repositories;

use App\Modules\Invoices\Application\InvoicesRepositoryInterface;
use App\Modules\Invoices\Domain\Invoice;

final class InvoicesRepository implements InvoicesRepositoryInterface
{
    public function get(string $id): Invoice
    {
        return Invoice::findOrFail($id);
    }

    public function getAll(): array
    {
        return Invoice::all()->toArray();
    }
}
