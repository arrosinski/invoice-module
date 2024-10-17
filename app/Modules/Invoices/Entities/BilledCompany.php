<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class BilledCompany implements \JsonSerializable
{
    private string $name;
    private string $street;
    private string $city;
    private string $zip;
    private string $phone;
    private string $email;

    public function __construct(
        string $name,
        string $street,
        string $city,
        string $zip,
        string $phone,
        string $email
    ) {
        $this->name = $name;
        $this->street = $street;
        $this->city = $city;
        $this->zip = $zip;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city,
            'zip' => $this->zip,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
