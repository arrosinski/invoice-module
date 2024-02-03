<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Domain\Enums\StatusEnum;
use App\Domain\Models\Money;
use DateTimeImmutable;
use Illuminate\Support\Collection;
use Ramsey\Uuid\UuidInterface;

readonly class Invoice
{
    /**
     * @param Collection<Product> $products
     */
    public function __construct(
        public UuidInterface $uuid,
        public string $number,
        public DateTimeImmutable $date,
        public DateTimeImmutable $dueDate,
        public StatusEnum $status,
        public Company $company,
        public Company $billingCompany,
        public Collection $products
    ) {
    }

    public function totalPrice(): Money
    {
        $sum = new Money(0);
        foreach ($this->products as $product) {
            $sum = $sum->add($product->totalPrice());
        }

        return $sum;
    }
}
