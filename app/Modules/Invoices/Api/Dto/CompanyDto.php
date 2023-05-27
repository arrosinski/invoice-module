<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use Ramsey\Uuid\UuidInterface;

final readonly class CompanyDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $id,
        public string $name,
        public string $street,
        public string $city,
        public string $zip,
        public string $phone,
        public string $email,
        public ?\DateTimeInterface $createdAt = null,
        public ?\DateTimeInterface $updatedAt = null,
    ) {
    }
}
