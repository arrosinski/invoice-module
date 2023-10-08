<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use App\Modules\Companies\Api\Dto\CompanyDto;
use App\Modules\Invoices\Domain\ValueObjects\InvoiceTotalsVO;
use App\Modules\Products\Api\Dto\ProductDto;

class InvoiceDto
{
    public function __construct(
        public ?int $id = null,
        public ?string $status = null,
        public ?CompanyDto $company = null,
        public ?CompanyDto $billedCompany = null,
        /** @var list<ProductDto> */
        public array $products = [],
        public ?InvoiceTotalsVO $totals = null,
    ) {
    }
}
