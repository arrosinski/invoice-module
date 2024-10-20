<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

use Ramsey\Uuid\UuidInterface;

class ApprovalInvoice
{
    private UuidInterface $id;
    private UuidInterface $number;
    private \DateTime $date;
    private \DateTime $dueDate;
    private Company $company;
    private BilledCompany $billedCompany;
    private ProductCollection $products;
    private string $totalPrice;
    private string $status;

    public function __construct(
        UuidInterface $id,
        UuidInterface $number,
        \DateTime $date,
        \DateTime $dueDate,
        Company $company,
        BilledCompany $billedCompany,
        ProductCollection $products,
        string $totalPrice,
        string $status
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->company = $company;
        $this->billedCompany = $billedCompany;
        $this->products = $products;
        $this->totalPrice = $totalPrice;
        $this->status = $status;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
