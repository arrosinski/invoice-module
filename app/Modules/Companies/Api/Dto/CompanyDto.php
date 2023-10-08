<?php

declare(strict_types=1);

namespace App\Modules\Companies\Api\Dto;

class CompanyDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $streetAddress = null,
        public ?string $city = null,
        public ?string $zipCode = null,
        public ?string $phone = null,
        public ?string $emailAddress = null,
    ) {
    }
}
