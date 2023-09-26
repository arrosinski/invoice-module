<?php

namespace App\Modules\Invoices\Application;

use App\Modules\Invoices\Domain\Entities\Invoice;

interface InvoicesFacadeInterface
{
    /**
     * @return Invoice[]
     */
    public function list(): array;

    public function get(string $id): Invoice;

    public function approve(string $id);

    public function reject(string $id);

}
