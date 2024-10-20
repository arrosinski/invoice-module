<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Repositories;

use App\Modules\Invoices\Entities\ApprovalInvoice;
interface InvoiceRepository
{
    public function findAll(): array;
    public function save(ApprovalInvoice $invoice): void;
}
