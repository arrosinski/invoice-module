<?php

namespace App\Modules\Invoices\Domain\Entities;

use App\Infrastructure\Traits\Builder;

readonly class Company
{
    use Builder;
    public string $id;
    public string $name;
    public string $street;
    public string $city;
    public string $zip;
    public string $phone;
    public string $email;
    public string $createdAt;
    public string $updatedAt;
    public function __construct(
    ) {
    }
}
