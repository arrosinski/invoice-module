<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class ProductCollection implements \IteratorAggregate, \JsonSerializable
{
    private $products = [];

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->products);
    }

    public function jsonSerialize()
    {
        return $this->products;
    }
}
