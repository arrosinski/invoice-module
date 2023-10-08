<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api;

use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Api\Dto\InvoiceResponseDto;

interface InvoicesFacadeInterface
{
    public function get(int $invoiceId): ?InvoiceDto;

    public function approveInvoice(InvoiceDto $invoiceDto): InvoiceResponseDto;

    public function rejectInvoice(InvoiceDto $invoiceDto): InvoiceResponseDto;
}
