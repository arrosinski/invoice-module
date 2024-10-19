<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Modules\Invoices\Entities\Product;
use App\Modules\Invoices\Entities\ProductCollection;
use App\Modules\Invoices\Services\TotalPriceCountingService;
use PHPUnit\Framework\TestCase;

class TotalPriceCountingServiceTest extends TestCase
{
    private TotalPriceCountingService $service;

    protected function setUp(): void
    {
        $this->service = new TotalPriceCountingService();
    }

    public function testCalculateTotalPriceWithNoProducts(): void
    {
        $products = new ProductCollection();
        $totalPrice = $this->service->calculateTotalPrice($products);
        $this->assertEquals('0 USD', $totalPrice);
    }

    public function testCalculateTotalPriceWithSingleProduct(): void
    {
        $products = new ProductCollection();
        $products->addProduct(new Product('Product 1', 100.0, 1));
        $totalPrice = $this->service->calculateTotalPrice($products);
        $this->assertEquals('106.25 USD', $totalPrice);
    }

    public function testCalculateTotalPriceWithMultipleProducts(): void
    {
        $products = new ProductCollection();
        $products->addProduct(new Product('Product 1', 100.0, 1));
        $products->addProduct(new Product('Product 2', 50.0, 2));
        $totalPrice = $this->service->calculateTotalPrice($products);
        $this->assertEquals('212.5 USD', $totalPrice);
    }
}
