<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Model;

use App\Domain\Enums\StatusEnum;
use App\Domain\ValueObjects\Money;
use App\Modules\Invoices\Infrastructure\Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ramsey\Uuid\Uuid;

class Invoice extends Model
{
    use HasFactory;
    use HasUuids;

    protected $casts = [
        'status' => StatusEnum::class,
    ];

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

    public function totalPrice(): Money
    {
        return $this->products->reduce(function (Money $carry, Product $product) {
            $total = $product->price->multiply($product->pivot->quantity);
            return $carry->add($total);
        }, new Money(0));
    }

    protected function id(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Uuid::fromString($value)
        );
    }

    protected static function newFactory(): Factory
    {
        return InvoiceFactory::new();
    }
}
