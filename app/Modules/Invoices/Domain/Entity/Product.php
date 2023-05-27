<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entity;

use App\Domain\Enums\CurrencyEnum;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

final class Product implements EntityInterface
{
    public function __construct(
        private readonly UuidInterface $id,
        private string $name,
        private CurrencyEnum $currency,
        private int $price,
        private int $quantity,
        private readonly ?\DateTimeInterface $createdAt,
        private readonly ?\DateTimeInterface $updatedAt,
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCurrency(): CurrencyEnum
    {
        return $this->currency;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotal(): int
    {
        return $this->quantity * $this->price;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getPriceFormatted(): string
    {
        $price = $this->price / 100;

        return sprintf(
            '%s %s',
            $this->currency->name,
            Str::currency($price)
        );
    }

    public function getTotalFormatted(): string
    {
        $total = $this->getTotal() / 100;

        return sprintf(
            '%s %s',
            $this->currency->name,
            Str::currency($total)
        );
    }
}
