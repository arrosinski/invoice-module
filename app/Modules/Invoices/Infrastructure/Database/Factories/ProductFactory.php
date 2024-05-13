<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Factories;

use App\Domain\Enums\CurrencyEnum;
use App\Modules\Invoices\Infrastructure\Model\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
final class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productNames = [
            'pen',
            'pencil',
            'razer',
            'gum',
            'towel',
            'backpack',
            'book',
            'shoes',
            'trousers',
            't-shirt',
            'snickers',
            'water',
            'coca-cola',
            'pepsi',
        ];

        return [
            'id' => $this->faker->uuid(),
            'name' => $productNames[array_rand($productNames)],
            'price' => rand(1111, 9999999),
            'currency' => CurrencyEnum::USD,
        ];
    }
}
