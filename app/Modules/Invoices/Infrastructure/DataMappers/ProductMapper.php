<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\DataMappers;

use App\Domain\Models\Money;
use App\Modules\Invoices\Domain\Models\Product;
use Ramsey\Uuid\UuidFactoryInterface;
use stdClass;

readonly class ProductMapper
{
    public function __construct(
        private UuidFactoryInterface $uuidFactory,
    ) {
    }

    public function map(stdClass $product): Product
    {
        return new Product(
            $this->uuidFactory->fromString($product->id),
            $product->name,
            $product->quantity,
            new Money($product->price),
        );
    }
}
