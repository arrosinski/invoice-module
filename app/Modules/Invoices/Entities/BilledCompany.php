<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class BilledCompany
{
    private $name;
    private $street;
    private $city;
    private $zip;
    private $phone;
    private $email;

    public function __construct(string $name, string $street, string $city, string $zip, string $phone, string $email)
    {
        $this->name = $name;
        $this->street = $street;
        $this->city = $city;
        $this->zip = $zip;
        $this->phone = $phone;
        $this->email = $email;
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

    public function getEmail(): string
    {
        return $this->email;
    }
}
