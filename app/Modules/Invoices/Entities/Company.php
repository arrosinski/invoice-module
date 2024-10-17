<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class Company implements \JsonSerializable
{
    private string $name;
    private string $street;
    private string $city;
    private string $zip;
    private string $phone;

    public function __construct(
        string $name,
        string $street,
        string $city,
        string $zip,
        string $phone
    ) {
        $this->name = $name;
        $this->street = $street;
        $this->city = $city;
        $this->zip = $zip;
        $this->phone = $phone;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city,
            'zip' => $this->zip,
            'phone' => $this->phone,
        ];
    }
}
