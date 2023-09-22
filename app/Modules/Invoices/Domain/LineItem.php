<?php

namespace App\Modules\Invoices\Domain;

class LineItem
{
    public string $id;
    public string $name;
    public int $quantity;
    public float $price;
    public float $total;
    public string $currency;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(
        string $id,
        string $name,
        int $quantity,
        float $price,
        float $total,
        string $currency,
        string $createdAt,
        string $updatedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->total = $total;
        $this->currency = $currency;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
