<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\DataMappers;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Models\InvoiceApproval;
use Ramsey\Uuid\UuidFactoryInterface;
use stdClass;

readonly class InvoiceApprovalMapper
{
    public function __construct(
        private UuidFactoryInterface $uuidFactory,
    ) {
    }

    public function map(stdClass $invoice): InvoiceApproval
    {
        return new InvoiceApproval(
            $this->uuidFactory->fromString($invoice->id),
            StatusEnum::tryFrom($invoice->status),
        );
    }
}
