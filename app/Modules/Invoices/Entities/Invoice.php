<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class Invoice implements \JsonSerializable
{
    private string $number;
    private \DateTime $date;
    private \DateTime $due_date;
    private Company $company;
    private BilledCompany $billedCompany;

    public function __construct(
        string $number,
        \DateTime $date,
        \DateTime $due_date,
        Company $company,
        BilledCompany $billedCompany
    ) {
        $this->number = $number;
        $this->date = $date;
        $this->due_date = $due_date;
        $this->company = $company;
        $this->billedCompany = $billedCompany;
    }

    public function jsonSerialize(): array
    {
        return [
            'number' => $this->number,
            'date' => $this->date->format('Y-m-d'),
            'due_date' => $this->due_date->format('Y-m-d'),
            'company' => $this->company,
            'billed_company' => $this->billedCompany,
        ];
    }
}
