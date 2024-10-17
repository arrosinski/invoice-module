<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class Invoice implements \JsonSerializable
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
    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'Invoice_number' => $this->number,
            'Invoice_date' => $this->date->format('Y-m-d'),
            'due_date' => $this->due_date->format('Y-m-d'),
        ];
    }
}
