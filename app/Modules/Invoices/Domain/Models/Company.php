<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use Ramsey\Uuid\UuidInterface;

readonly class Company
{
    public function __construct(
        public UuidInterface $uuid,
        public string $name,
        public string $streetAddress,
        public string $city,
        public string $zipCode,
        public string $phoneNumber,
        public string $email,
    ) {
    }
}
