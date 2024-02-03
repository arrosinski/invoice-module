<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Services;

use App\Modules\Invoices\Application\Exceptions\InvoiceNotFoundException;
use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepository;
use Ramsey\Uuid\UuidInterface;

readonly class InvoiceService
{
    public function __construct(
        private InvoiceRepository $invoiceRepository,
    ) {
    }

    public function getInvoice(UuidInterface $uuid): Invoice
    {
        return $this->invoiceRepository->findById($uuid) ?? throw new InvoiceNotFoundException($uuid);
    }
}
