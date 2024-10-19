<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Services;

use App\Modules\Invoices\Entities\ProductCollection;

class TotalPriceCountingService
{
    private const SALES_TAX = 0.0625;

    private const CURRENCY = '$';

    public function calculateTotalPrice(ProductCollection $products): string
    {
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product->getTotal();
        }

        return self::CURRENCY.number_format($totalPrice * (1 + self::SALES_TAX), 2);
    }
}
