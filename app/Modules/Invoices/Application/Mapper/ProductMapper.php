<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Mapper;

use App\Domain\Enums\CurrencyEnum;
use App\Modules\Invoices\Api\Dto\DtoInterface;
use App\Modules\Invoices\Api\Dto\ProductDto;
use App\Modules\Invoices\Domain\Entity\EntityInterface;
use App\Modules\Invoices\Domain\Entity\Product;
use Ramsey\Uuid\Uuid;

final class ProductMapper implements EntityMapperInterface, DtoMapperInterface, ArrayMapperInterface
{
    /**
     * @throws \Exception
     */
    public static function fromRawToEntity(object $raw): Product
    {
        return new Product(
            Uuid::fromString($raw->id),
            $raw->name,
            CurrencyEnum::tryFrom($raw->currency),
            $raw->price,
            $raw->quantity,
            new \DateTimeImmutable($raw->created_at),
            new \DateTimeImmutable($raw->updated_at),
        );
    }

    /**
     * @param Product $entity
     */
    public static function fromEntityToDto(EntityInterface $entity): ProductDto
    {
        return new ProductDto(
            $entity->getId(),
            $entity->getName(),
            $entity->getCurrency(),
            $entity->getPrice(),
            $entity->getPriceFormatted(),
            $entity->getQuantity(),
            $entity->getTotal(),
            $entity->getTotalFormatted(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt(),
        );
    }

    /**
     * @inheritDoc
     *
     * @param ProductDto $dto
     */
    public static function fromDtoToArray(
        DtoInterface $dto,
        bool $format = true,
        bool $timestamps = false
    ): array {
        $total = $format ? $dto->totalFormatted : $dto->total;
        $price = $format ? $dto->priceFormatted : $dto->price;

        $return = [
            'name' => $dto->name,
            'quantity' => $dto->quantity,
            'unitPrice' => $price,
            'total' => $total,
        ];

        if ($timestamps) {
            $return = [
                ...$return,
                'createdAt' => $dto->createdAt?->format('c'),
                'updatedAt' => $dto->updatedAt?->format('c'),
            ];
        }

        return $return;
    }
}
