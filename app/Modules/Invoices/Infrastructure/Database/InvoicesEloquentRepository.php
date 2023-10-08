<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database;

use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Application\Repository\InvoicesRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Database\Entities\InvoiceEntity;
use App\Modules\Invoices\Infrastructure\Database\Mappers\InvoicesEloquentMapper;

class InvoicesEloquentRepository implements InvoicesRepositoryInterface
{
    public function __construct(
        private readonly InvoicesEloquentMapper $invoicesEloquentMapper
    ) {
    }

    public function update(InvoiceDto $invoiceDto): InvoiceDto
    {
        /** @var InvoiceEntity $invoiceEntity */
        $invoiceEntity = InvoiceEntity::query()->where('id', $invoiceDto->id)->first();
        if (null === $invoiceEntity) {
            return $invoiceDto;
        }

        return $this->invoicesEloquentMapper->mapInvoiceEntityToInvoiceDto($invoiceEntity, $invoiceDto);
    }

    public function get(int $id): ?InvoiceDto
    {
        /** @var InvoiceEntity $invoiceEntity */
        $invoiceEntity = InvoiceEntity::query()->where('id', $id)->first();
        if (null === $invoiceEntity) {
            return null;
        }

        return $this->invoicesEloquentMapper->mapInvoiceEntityToInvoiceDto($invoiceEntity, new InvoiceDto());
    }
}
