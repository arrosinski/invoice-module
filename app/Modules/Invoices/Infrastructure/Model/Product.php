<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Model;

use App\Infrastructure\Casts\MoneyCast;
use App\Modules\Invoices\Infrastructure\Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use HasUuids;

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }
}
