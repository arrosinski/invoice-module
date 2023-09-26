<?php

namespace App\Modules\Invoices\Api\Dto;

use App\Infrastructure\Traits\ToArray;
use App\Modules\Invoices\Domain\Entities\Invoice;

class InvoiceListViewModel
{
    use ToArray;

    public function __construct(
        public string $id,
        public string $number,
        public string $date,
        public string $dueDate,
        public string $status,
        public string $createdAt,
        public string $updatedAt,
        public array $_links = [])
    {
    }

    public static function fromArray(array $data, array $links): InvoiceListViewModel
    {
        return new self(
            $data['id'],
            $data['number'],
            $data['date'],
            $data['due_date'],
            $data['status'],
            $data['created_at'],
            $data['updated_at'],
            $links,
        );
    }

    public static function fromInvoice(Invoice $invoice, array $links): InvoiceListViewModel
    {
        return new self(
            $invoice->id,
            $invoice->number,
            $invoice->date,
            $invoice->dueDate,
            $invoice->status->value,
            $invoice->createdAt,
            $invoice->updatedAt,
            $links,
        );
    }



}
