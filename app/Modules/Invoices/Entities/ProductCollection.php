<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class ProductCollection implements \JsonSerializable
{
    private array $products;

    public function __construct(array $products = [])
    {
        $this->products = $products;
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function jsonSerialize(): array
    {
        return $this->products;
    }
}
