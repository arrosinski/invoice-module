<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Exceptions;

use DomainException;
use Ramsey\Uuid\UuidInterface;

class InvoiceNotFoundException extends DomainException
{
    public function __construct(UuidInterface $uuid)
    {
        parent::__construct(sprintf('Invoice %s not found', $uuid->toString()));
    }
}
