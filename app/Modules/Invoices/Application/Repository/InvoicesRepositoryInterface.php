<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Repository;

use App\Modules\Invoices\Api\Dto\InvoiceDto;

interface InvoicesRepositoryInterface
{
    public function update(InvoiceDto $invoiceDto): InvoiceDto;

    public function get(int $id): ?InvoiceDto;
}
