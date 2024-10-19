<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class Company
{
    private $name;
    private $street;
    private $city;
    private $zip;
    private $phone;

    public function __construct(string $name, string $street, string $city, string $zip, string $phone)
    {
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
}
