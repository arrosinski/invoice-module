<?php

declare(strict_types=1);

namespace Tests\Modules\Invoices\Domain\Models;

use App\Domain\Enums\StatusEnum;
use App\Domain\Models\Money;
use App\Modules\Invoices\Domain\Models\Company;
use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Domain\Models\Product;
use DateTimeImmutable;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class InvoiceTest extends TestCase
{
    public function testTotalPrice(): void
    {
        $invoice = new Invoice(
            Uuid::uuid4(),
            'IB1003',
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            StatusEnum::DRAFT,
            $this->company(),
            $this->company(),
            new Collection([
                new Product(Uuid::uuid4(), 'name1', 3, new Money(100)),
                new Product(Uuid::uuid4(), 'name2', 4, new Money(50)),
            ])
        );

        $this->assertEquals(new Money(500), $invoice->totalPrice());
    }

    private function company(): Company
    {
        return new Company(
            Uuid::uuid4(),
            'name',
            'street',
            'city',
            'zip',
            'phone',
            'email'
        );
    }
}
