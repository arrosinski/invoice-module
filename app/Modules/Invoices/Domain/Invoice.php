<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use App\Domain\Enums\StatusEnum;
use Ramsey\Uuid\UuidInterface;

#[AggregateRoot]
final class Invoice
{
    private StatusEnum $status;

    public function __construct(
        public readonly UuidInterface $id
    ) {
        $this->status = StatusEnum::DRAFT;
    }

    public function approve(): void
    {
        $this->validateStatus();
        $this->status = StatusEnum::APPROVED;
    }

    public function isApproved(): bool
    {
        return StatusEnum::APPROVED === $this->status;
    }

    public function reject(): void
    {
        $this->validateStatus();
        $this->status = StatusEnum::REJECTED;
    }

    public function isRejected(): bool
    {
        return StatusEnum::REJECTED === $this->status;
    }

    private function validateStatus(): void
    {
        if (StatusEnum::DRAFT !== StatusEnum::tryFrom($this->status->value)) {
            throw new \DomainException('Status cannot be changed.');
        }
    }
}
