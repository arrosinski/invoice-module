<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Repositories\Mappers;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Invoice as DomainInvoice;
use App\Modules\Invoices\Infrastructure\Model\Invoice as EloquentInvoice;
use Ramsey\Uuid\Uuid;

final class EloquentInvoiceMapper
{
    public function toDomain(EloquentInvoice $model): DomainInvoice
    {
        $invoice = new DomainInvoice(Uuid::fromString($model->id));

        switch (StatusEnum::tryFrom($model->status)) {
            case StatusEnum::APPROVED:
                $invoice->approve();
                break;
            case StatusEnum::REJECTED:
                $invoice->reject();
                break;
        }

        return $invoice;
    }

    public function toEloquent(DomainInvoice $invoice): EloquentInvoice
    {
        $model = EloquentInvoice::findOrFail($invoice->id);
        if ($invoice->isApproved()) {
            $model->status = StatusEnum::APPROVED;
        }

        if ($invoice->isRejected()) {
            $model->status = StatusEnum::REJECTED;
        }

        return $model;
    }
}
