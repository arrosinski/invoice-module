<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Reader;

use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Application\Repository\InvoicesRepositoryInterface;

class InvoicesReader
{
    public function __construct(
        private readonly InvoicesRepositoryInterface $invoicesRepository
    ) {
    }

    public function getInvoiceById(int $id): ?InvoiceDto
    {
        return $this->invoicesRepository->get($id);
    }
}
