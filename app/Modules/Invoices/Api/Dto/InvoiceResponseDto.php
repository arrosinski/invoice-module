<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use App\Domain\ErrorDto;

class InvoiceResponseDto
{
    public function __construct(
        public ?InvoiceDto $invoiceDto,
        public ?bool $isSuccess = null,
        /** @var list<ErrorDto> */
        public array $errors = [],
    ) {
    }
}
