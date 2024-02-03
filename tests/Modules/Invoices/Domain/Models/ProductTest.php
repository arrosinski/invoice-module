<?php

declare(strict_types=1);

namespace Tests\Modules\Invoices\Domain\Models;

use App\Domain\Models\Money;
use App\Modules\Invoices\Domain\Models\Product;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductTest extends TestCase
{
    public function testTotalPrice(): void
    {
        $product = new Product(Uuid::uuid4(), 'name', 3, new Money(100));

        $this->assertEquals(new Money(300), $product->totalPrice());
    }
}
