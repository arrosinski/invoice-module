<?php

namespace App\Modules\Invoices\Domain\Repositories;

use App\Modules\Invoices\Domain\Entities\Invoice;
use stdClass;

interface InvoiceRepositoryInterface
{
    public function update(Invoice $invoice): void;
    public function getById(string $id): ?Invoice;
    public function approve(string $id): ?Invoice;
    public function reject(string $id): ?Invoice;
    public function getCompany(string $companyId): stdClass;
}
