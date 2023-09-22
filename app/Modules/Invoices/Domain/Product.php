<?php

namespace App\Modules\Invoices\Domain;

class Product
{
    private int $id;
    private string $name;
    private float $price;
    private string $currency;
    private string $createdAt;
    private string $updatedAt;
}
