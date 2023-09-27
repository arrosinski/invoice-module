<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\ValueObjects;

enum StatusEnum: string
{
    case DRAFT = 'draft';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    const UNDEFINED = 'undefined';

    public function equals(StatusEnum $DRAFT): bool
    {
        return $this->value === $DRAFT->value;
    }
}
