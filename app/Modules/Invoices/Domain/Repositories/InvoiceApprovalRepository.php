<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Repositories;

use App\Modules\Invoices\Domain\Models\InvoiceApproval;
use Ramsey\Uuid\UuidInterface;

interface InvoiceApprovalRepository
{
    public function findById(UuidInterface $uuid): ?InvoiceApproval;

    public function update(InvoiceApproval $invoice): void;
}
