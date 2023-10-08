<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Mappers;

use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Infrastructure\Database\Entities\InvoiceEntity;

class InvoicesEloquentMapper
{
    public function mapInvoiceEntityToInvoiceDto(InvoiceEntity $invoiceEntity, InvoiceDto $invoiceDto): InvoiceDto
    {
        // map properties and return

        return $invoiceDto;
    }
}
