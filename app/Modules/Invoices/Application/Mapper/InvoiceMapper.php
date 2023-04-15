<?php

namespace App\Modules\Invoices\Application\Mapper;

use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Application\DTO\InvoiceDTO;

class InvoiceMapper
{
    public static function toEntity(InvoiceDTO $dto): Invoice
    {
        $invoice = new Invoice(
            $dto->getId(),
            $dto->getNumber(),
            $dto->getDate(),
            $dto->getDueDate(),
            $dto->getCompany(),
            $dto->getStatus(),
            $dto->getItems()
        );

        return $invoice;
    }

    public static function toDTO(Invoice $invoice): InvoiceDTO
    {
        $dto = new InvoiceDTO(
            $invoice->getId(),
            $invoice->getNumber(),
            $invoice->getDate(),
            $invoice->getDueDate(),
            $invoice->getCompany(),
            $invoice->getStatus(),
            $invoice->getItems()
        );

        return $dto;
    }
}
