<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class Invoice implements \JsonSerializable
{
    private string $number;
    private \DateTime $date;
    private \DateTime $due_date;
    private Company $company;

    public function __construct(
        string $number,
        \DateTime $date,
        \DateTime $due_date,
        Company $company
    ) {
        $this->number = $number;
        $this->date = $date;
        $this->due_date = $due_date;
        $this->company = $company;
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
        return $this->due_date;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function jsonSerialize(): array
    {
        return [
            'number' => $this->number,
            'date' => $this->date->format('Y-m-d'),
            'due_date' => $this->due_date->format('Y-m-d'),
            'company' => $this->company,
        ];
    }
}
