<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entity;

use App\Domain\Enums\StatusEnum;
use EduardoMarques\TypedCollections\TypedCollectionInterface;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

final class Invoice implements EntityInterface
{
    public function __construct(
        private readonly UuidInterface $id,
        private UuidInterface $number,
        private \DateTimeInterface $date,
        private \DateTimeInterface $dueDate,
        private Company $company,
        private StatusEnum $status,
        private TypedCollectionInterface $products,
        private readonly ?\DateTimeInterface $createdAt,
        private readonly ?\DateTimeInterface $updatedAt,
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getNumber(): UuidInterface
    {
        return $this->number;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getDueDate(): \DateTimeInterface
    {
        return $this->dueDate;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getProducts(): TypedCollectionInterface
    {
        return $this->products;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getProductsTotal(): int
    {
        return $this->products->reduce(
            static fn(int $carry, Product $product): int => $carry += $product->getTotal(),
            0
        );
    }

    public function getProductsTotalFormatted(): string
    {
        $productsTotal = $this->getProductsTotal();

        /** @var Product|null $firstProduct */
        $firstProduct = $this->products->first();

        return sprintf(
            '%s %s',
            $firstProduct?->getCurrency()->name,
            Str::currency($productsTotal)
        );
    }

    public function approve(): self
    {
        $this->status = StatusEnum::APPROVED;

        return $this;
    }

    public function reject(): self
    {
        $this->status = StatusEnum::REJECTED;

        return $this;
    }
}
