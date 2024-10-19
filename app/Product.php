<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'name',
        'price',
    ];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_product_lines')
            ->withPivot('quantity');
    }
}
