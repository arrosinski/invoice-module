<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class Invoice
{
    private $number;
    private $date;
    private $dueDate;
    private $company;
    private $billedCompany;
    private $products;
    private $totalPrice;

    public function __construct(
        string $number,
        \DateTime $date,
        \DateTime $dueDate,
        Company $company,
        BilledCompany $billedCompany,
        ProductCollection $products,
        string $totalPrice
    ) {
        $this->number = $number;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->company = $company;
        $this->billedCompany = $billedCompany;
        $this->products = $products;
        $this->totalPrice = $totalPrice;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getDueDate(): \DateTime
    {
        return $this->dueDate;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function getBilledCompany(): BilledCompany
    {
        return $this->billedCompany;
    }

    public function getProducts(): ProductCollection
    {
        return $this->products;
    }

    public function getTotalPrice(): string
    {
        return $this->totalPrice;
    }
}
