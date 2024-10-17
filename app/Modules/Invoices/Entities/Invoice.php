<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class Invoice
{
    private string $number;
    private \DateTime $date;
    private \DateTime $due_date;

    public function __construct(
        string $number,
        \DateTime $date,
        \DateTime $due_date
    ) {
        $this->number = $number;
        $this->date = $date;
        $this->due_date = $due_date;
    }

    // Getters for each property
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
        return $this->due_date;
    }
}
