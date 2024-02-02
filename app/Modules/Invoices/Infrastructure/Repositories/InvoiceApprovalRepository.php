<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Models\InvoiceApproval;
use App\Modules\Invoices\Domain\Repositories\InvoiceApprovalRepository as RepositoryContract;
use App\Modules\Invoices\Infrastructure\DataMappers\InvoiceApprovalMapper;
use Illuminate\Database\ConnectionInterface;
use Ramsey\Uuid\UuidInterface;

readonly class InvoiceApprovalRepository implements RepositoryContract
{
    public function __construct(
        private ConnectionInterface $db,
        private InvoiceApprovalMapper $mapper
    ) {
    }

    public function findById(UuidInterface $uuid): ?InvoiceApproval
    {
        $invoice = $this->db
            ->table('invoices')
            ->find($uuid->toString());

        return $invoice ? $this->mapper->map($invoice) : null;
    }

    public function update(InvoiceApproval $invoice): void
    {
        $this->db
            ->table('invoices')
            ->where([
                'id' => $invoice->uuid->toString(),
                'status' => StatusEnum::DRAFT->value,
            ])
            ->update(['status' => $invoice->getStatus()->value]);
    }
}
