<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Domain\Models\Money;
use Ramsey\Uuid\UuidInterface;

readonly class Product
{
    public function __construct(
        public UuidInterface $uuid,
        public string $name,
        public int $quantity,
        public Money $unitPrice,
    ) {
    }

    public function totalPrice(): Money
    {
        return $this->unitPrice->multiply($this->quantity);
    }
}
