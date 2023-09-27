<?php

namespace App\Modules\Invoices\Domain\Entities;

use App\Infrastructure\Traits\Builder;
use App\Modules\Invoices\Domain\Policies\CanChangeStatusPolicy;
use App\Modules\Invoices\Domain\ValueObjects\StatusEnum;

class Invoice
{
    use Builder;

    public string $id;
    public string $number;
    public string $date;
    public string $dueDate;
    public StatusEnum $status;

    public Company $company;
    public array $lineItems;
    public float $grandTotal;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(
    ) {
    }

    public function canApprove(): bool
    {
        return CanChangeStatusPolicy::check($this);
    }

    public function canReject(): bool
    {
        return CanChangeStatusPolicy::check($this);
    }


}

