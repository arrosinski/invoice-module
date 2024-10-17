<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Repositories;

interface InvoiceRepository
{
    public function findAll(): array;
}
