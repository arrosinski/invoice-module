<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\DataMappers;

use App\Modules\Invoices\Domain\Models\Company;
use Ramsey\Uuid\UuidFactoryInterface;
use stdClass;

readonly class CompanyMapper
{
    public function __construct(
        private UuidFactoryInterface $uuidFactory,
    ) {
    }

    public function map(stdClass $company): Company
    {
        return new Company(
            $this->uuidFactory->fromString($company->id),
            $company->name,
            $company->street,
            $company->city,
            $company->zip,
            $company->phone,
            $company->email,
        );
    }
}
