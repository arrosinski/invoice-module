<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Services;

use App\Modules\Invoices\Repositories\InvoiceRepository;

class InvoiceService
{
    private InvoiceRepository $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    /** @return array<InvoiceEntity> */
    public function getAllInvoices(): array
    {
        return $this->invoiceRepository->findAll();
    }
}
