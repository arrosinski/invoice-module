<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use App\Domain\Enums\CurrencyEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class ProductDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $id,
        public string $name,
        public CurrencyEnum $currency,
        public int $price,
        public string $priceFormatted,
        public int $quantity,
        public int $total,
        public string $totalFormatted,
        public ?\DateTimeInterface $createdAt = null,
        public ?\DateTimeInterface $updatedAt = null,
    ) {
    }
}
