<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

final class Invoice
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public function __construct(
        public string $status = self::STATUS_PENDING,
    ) {
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function approve(): void
    {
        if (self::STATUS_REJECTED === $this->status) {
            throw new \LogicException('Cannot approve an invoice that has been rejected.');
        }

        $this->status = self::STATUS_APPROVED;
    }

    public function reject(): void
    {
        if (self::STATUS_APPROVED === $this->status) {
            throw new \LogicException('Cannot reject an invoice that has been approved.');
        }

        $this->status = self::STATUS_REJECTED;
    }
}
