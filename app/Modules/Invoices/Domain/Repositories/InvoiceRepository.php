<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Repositories;

use App\Modules\Invoices\Domain\Models\Invoice;
use Ramsey\Uuid\UuidInterface;

interface InvoiceRepository
{
    public function findById(UuidInterface $uuid): ?Invoice;
}
