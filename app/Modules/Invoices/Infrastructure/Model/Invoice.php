<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Model;

use App\Modules\Invoices\Infrastructure\Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    use HasFactory;
    use HasUuids;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'invoice_product_lines'
        )->withPivot('quantity');
    }

    public function totalPrice(): int
    {
        return $this->products->reduce(function (int $carry, Product $product) {
            return $carry + $product->pivot->quantity * $product->price;
        }, 0);
    }

    protected static function newFactory(): Factory
    {
        return InvoiceFactory::new();
    }
}
