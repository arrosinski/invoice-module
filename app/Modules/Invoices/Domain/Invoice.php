<?php

namespace App\Modules\Invoices\Domain;

use App\Domain\Enums\StatusEnum;

class Invoice
{
    public string $id;
    public string $number;
    public string $date;
    public string $dueDate;
    public Company $company;
    public StatusEnum $status;

    /**
     * @var LineItem[]
     */
    public array $lineItems;

    public string $createdAt;
    public string $updatedAt;

    public function __construct(
        string $id,
        string $number,
        string $date,
        string $dueDate,
        StatusEnum $status,
        Company $company,
        array $lineItems,
        string $createdAt,
        string $updatedAt
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->status = $status;
        $this->company = $company;
        $this->lineItems = $lineItems;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}

