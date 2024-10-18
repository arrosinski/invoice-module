<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class Product implements \JsonSerializable
{
    private string $name;
    private float $price;
    private int $quantity;
    private float $total;

    public function __construct(
        string $name,
        float $price,
        int $quantity
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->total = $price * $quantity;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'total' => $this->total,
        ];
    }
}
