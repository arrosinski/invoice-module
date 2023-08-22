<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entity;

use App\Domain\Enums\CurrencyEnum;
use App\Domain\Enums\StatusEnum;
use EduardoMarques\TypedCollections\TypedCollectionImmutable;
use EduardoMarques\TypedCollections\TypedCollectionInterface;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

final class Invoice implements EntityInterface
{
    private Company $company;

    private TypedCollectionInterface $products;

    public function __construct(
        private readonly UuidInterface $id,
        private UuidInterface $number,
        private \DateTimeInterface $date,
        private \DateTimeInterface $dueDate,
        private StatusEnum $status,
        private readonly ?\DateTimeInterface $createdAt = null,
        private readonly ?\DateTimeInterface $updatedAt = null,
    ) {
        $this->products = TypedCollectionImmutable::create(Product::class);
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

    public function setCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getProducts(): TypedCollectionInterface
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        $this->products = $this->products->add($product);

        return $this;
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
            $firstProduct?->getCurrency()->name ?? CurrencyEnum::USD->name,
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
