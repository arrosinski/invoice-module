<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Repositories;

use App\Modules\Invoices\Application\InvoiceRepositoryInterface;
use App\Modules\Invoices\Domain\Invoice as DomainInvoice;
use App\Modules\Invoices\Infrastructure\Model\Invoice as EloquentInvoice;
use App\Modules\Invoices\Infrastructure\Repositories\Mappers\EloquentInvoiceMapper;
use Ramsey\Uuid\UuidInterface;

final class EloquentInvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(
        private readonly EloquentInvoiceMapper $mapper
    ) {
    }
    public function get(UuidInterface $id): DomainInvoice
    {
        $invoice = EloquentInvoice::findOrFail($id);

        return $this->mapper->toDomain($invoice);
    }

    public function save(DomainInvoice $invoice): void
    {
        $invoice = $this->mapper->toEloquent($invoice);
        $invoice->save();
    }
}
