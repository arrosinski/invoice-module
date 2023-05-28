<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use App\Domain\Enums\StatusEnum;
use EduardoMarques\TypedCollections\TypedCollectionInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class InvoiceDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $id,
        public UuidInterface $number,
        public \DateTimeInterface $date,
        public \DateTimeInterface $dueDate,
        public CompanyDto $company,
        public StatusEnum $status,
        public TypedCollectionInterface $products,
        public int $total,
        public string $totalFormatted,
        public ?\DateTimeInterface $createdAt = null,
        public ?\DateTimeInterface $updatedAt = null,
    ) {
    }
}
