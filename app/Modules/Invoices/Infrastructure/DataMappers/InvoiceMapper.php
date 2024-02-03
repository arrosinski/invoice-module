<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\DataMappers;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Models\Invoice;
use DateTimeImmutable;
use Illuminate\Support\Collection;
use Ramsey\Uuid\UuidFactoryInterface;
use stdClass;

readonly class InvoiceMapper
{
    public function __construct(
        private UuidFactoryInterface $uuidFactory,
        private CompanyMapper $companyMapper,
        private ProductMapper $productMapper,
    ) {
    }

    public function map(
        stdClass $invoice,
        stdClass $company,
        stdClass $billingCompany,
        Collection $products,
    ): Invoice {
        return new Invoice(
            $this->uuidFactory->fromString($invoice->id),
            $invoice->number,
            new DateTimeImmutable($invoice->date),
            new DateTimeImmutable($invoice->due_date),
            StatusEnum::tryFrom($invoice->status),
            $this->companyMapper->map($company),
            $this->companyMapper->map($billingCompany),
            $products->map(fn(stdClass $product) => $this->productMapper->map($product)),
        );
    }
}
