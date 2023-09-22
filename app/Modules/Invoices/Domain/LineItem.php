<?php

namespace App\Modules\Invoices\Domain;

class LineItem
{

    protected $table = 'invoice_product_lines';
    protected $keyType = 'string';
    private int $id;
    private int $quantity;
    private float $price;
    private float $total;
    private string $createdAt;
    private string $updatedAt;

    public function product(): Product
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
