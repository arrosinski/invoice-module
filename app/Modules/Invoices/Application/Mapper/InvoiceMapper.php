<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Mapper;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Api\Dto\DtoInterface;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Api\Dto\ProductDto;
use App\Modules\Invoices\Domain\Entity\EntityInterface;
use App\Modules\Invoices\Domain\Entity\Invoice;
use App\Modules\Invoices\Domain\Entity\Product;
use EduardoMarques\TypedCollections\TypedCollectionImmutable;
use Ramsey\Uuid\Uuid;

final class InvoiceMapper implements
    EntityMapperInterface,
    DtoMapperInterface,
    ArrayMapperInterface,
    PersistenceArrayMapperInterface
{
    /**
     * @throws \Exception
     */
    public static function fromRawToEntity(object $raw): Invoice
    {
        return new Invoice(
            Uuid::fromString($raw->id),
            Uuid::fromString($raw->number),
            new \DateTimeImmutable($raw->date),
            new \DateTimeImmutable($raw->dueDate),
            StatusEnum::tryFrom($raw->status),
            isset($raw->createdAt) ? new \DateTimeImmutable($raw->createdAt) : null,
            isset($raw->updatedAt) ? new \DateTimeImmutable($raw->updatedAt) : null,
        );
    }

    /**
     * @param Invoice $entity
     *
     * @throws \Exception
     */
    public static function fromEntityToDto(EntityInterface $entity): InvoiceDto
    {
        $company = CompanyMapper::fromEntityToDto($entity->getCompany());

        $products = $entity->getProducts();

        $products = $products->count() > 0
            ? $products->map(static fn(Product $product): ProductDto => ProductMapper::fromEntityToDto($product))
            : TypedCollectionImmutable::create(ProductDto::class);

        return new InvoiceDto(
            $entity->getId(),
            $entity->getNumber(),
            $entity->getDate(),
            $entity->getDueDate(),
            $company,
            $entity->getStatus(),
            $products,
            $entity->getProductsTotal(),
            $entity->getProductsTotalFormatted(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt(),
        );
    }

    /**
     * @inheritDoc
     *
     * @param InvoiceDto $dto
     */
    public static function fromDtoToArray(
        DtoInterface $dto,
        bool $format = true,
        bool $timestamps = false
    ): array {
        $company = CompanyMapper::fromDtoToArray($dto->company, $format, $timestamps);

        $products = $dto->products;

        $products = 0 === $products->count()
            ? TypedCollectionImmutable::create('array')
            : $products->map(
                static fn(ProductDto $product): array => ProductMapper::fromDtoToArray($product, $format, $timestamps)
            );

        $total = $format ? $dto->totalFormatted : $dto->total;

        $return = [
            'number' => $dto->number->toString(),
            'date' => $dto->date->format('c'),
            'dueDate' => $dto->dueDate->format('c'),
            'company' => $company,
            'products' => $products->toArray(),
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

    /**
     * @inheritDoc
     *
     * @param Invoice $entity
     */
    public static function fromEntityToPersistenceArray(EntityInterface $entity): array
    {
        return [
            'number' => $entity->getNumber()->toString(),
            'date' => $entity->getDate()->format('Y-m-d'),
            'due_date' => $entity->getDueDate()->format('Y-m-d'),
            'company_id' => $entity->getCompany()->getId()->toString(),
            'status' => $entity->getStatus()->value,
        ];
    }
}
