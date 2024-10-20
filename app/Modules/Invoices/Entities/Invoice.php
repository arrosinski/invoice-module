<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

use Ramsey\Uuid\UuidInterface;

class Invoice
{
    private UuidInterface $number;
    private \DateTime $date;
    private \DateTime $dueDate;
    private Company $company;
    private BilledCompany $billedCompany;
    private ProductCollection $products;
    private string $totalPrice;

    public function __construct(
        UuidInterface $number,
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

    public function getNumber(): UuidInterface
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
