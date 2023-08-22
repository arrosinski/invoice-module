<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Application\Mapper;

use App\Domain\Enums\CurrencyEnum;
use App\Modules\Invoices\Api\Dto\ProductDto;
use App\Modules\Invoices\Application\Mapper\ProductMapper;
use App\Modules\Invoices\Domain\Entity\Product;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\CreatesApplication;

final class ProductMapperTest extends TestCase
{
    use CreatesApplication;

    /**
     * @throws \Exception
     */
    public function testFromRawToEntity(): void
    {
        $productId = Uuid::uuid1();
        $name = uniqid('name-');
        $currency = CurrencyEnum::USD;
        $price = rand(1, 999999);
        $quantity = rand(1, 999999);

        $raw = new \stdClass();
        $raw->id = $productId->toString();
        $raw->name = $name;
        $raw->currency = $currency->value;
        $raw->price = $price;
        $raw->quantity = $quantity;

        $expected = new Product(
            $productId,
            $name,
            $currency,
            $price,
            $quantity,
        );

        $this->assertEquals($expected, ProductMapper::fromRawToEntity($raw));
    }

    /**
     * @throws \Exception
     */
    public function testFromRawToEntityWithTimestamps(): void
    {
        $productId = Uuid::uuid1();
        $name = uniqid('name-');
        $currency = CurrencyEnum::USD;
        $price = rand(1, 999999);
        $quantity = rand(1, 999999);
        $createdAt = '2023-05-27 00:00:00';
        $updatedAt = '2023-05-27 00:52:00';

        $raw = new \stdClass();
        $raw->id = $productId->toString();
        $raw->name = $name;
        $raw->currency = $currency->value;
        $raw->price = $price;
        $raw->quantity = $quantity;
        $raw->createdAt = $createdAt;
        $raw->updatedAt = $updatedAt;

        $expected = new Product(
            $productId,
            $name,
            $currency,
            $price,
            $quantity,
            new \DateTimeImmutable($createdAt),
            new \DateTimeImmutable($updatedAt),
        );

        $this->assertEquals($expected, ProductMapper::fromRawToEntity($raw));
    }

    public function testFromEntityToDto(): void
    {
        $productId = Uuid::uuid1();
        $name = uniqid('name-');
        $currency = CurrencyEnum::USD;
        $price = rand(1, 999999);
        $quantity = rand(1, 999999);
        $total = $price * $quantity;

        $priceFormatted = sprintf(
            '%s %s',
            $currency->name,
            Str::currency($price / 100)
        );

        $totalFormatted = sprintf(
            '%s %s',
            $currency->name,
            Str::currency($total / 100)
        );

        $company = new Product(
            $productId,
            $name,
            $currency,
            $price,
            $quantity,
        );

        $expected = new ProductDto(
            $productId,
            $name,
            $currency,
            $price,
            $priceFormatted,
            $quantity,
            $total,
            $totalFormatted,
        );

        $this->assertEquals($expected, ProductMapper::fromEntityToDto($company));
    }

    public function testFromDtoToArrayWithFormattingAndTimestamps(): void
    {
        $productId = Uuid::uuid1();
        $name = uniqid('name-');
        $currency = CurrencyEnum::USD;
        $price = rand(1, 999999);
        $quantity = rand(1, 999999);
        $total = $price * $quantity;

        $priceFormatted = sprintf(
            '%s %s',
            $currency->name,
            Str::currency($price / 100)
        );

        $totalFormatted = sprintf(
            '%s %s',
            $currency->name,
            Str::currency($total / 100)
        );

        $productDto = new ProductDto(
            $productId,
            $name,
            $currency,
            $price,
            $priceFormatted,
            $quantity,
            $total,
            $totalFormatted,
        );

        $expected = [
            'name' => $name,
            'quantity' => $quantity,
            'unitPrice' => $priceFormatted,
            'total' => $totalFormatted,
            'createdAt' => null,
            'updatedAt' => null,
        ];

        $this->assertEquals($expected, ProductMapper::fromDtoToArray(dto: $productDto, timestamps: true));
    }

    public function testFromDtoToArrayWithoutFormattingAndTimestamps(): void
    {
        $productId = Uuid::uuid1();
        $name = uniqid('name-');
        $currency = CurrencyEnum::USD;
        $price = rand(1, 999999);
        $quantity = rand(1, 999999);
        $total = $price * $quantity;

        $priceFormatted = sprintf(
            '%s %s',
            $currency->name,
            Str::currency($price / 100)
        );

        $totalFormatted = sprintf(
            '%s %s',
            $currency->name,
            Str::currency($total / 100)
        );

        $productDto = new ProductDto(
            $productId,
            $name,
            $currency,
            $price,
            $priceFormatted,
            $quantity,
            $total,
            $totalFormatted,
        );

        $expected = [
            'name' => $name,
            'quantity' => $quantity,
            'unitPrice' => $price,
            'total' => $total,
        ];

        $this->assertEquals($expected, ProductMapper::fromDtoToArray($productDto, false));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->createApplication();
    }
}
