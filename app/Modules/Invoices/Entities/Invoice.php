<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Entities;

class Invoice
{
    private string $id;
    private string $number;
    private \DateTime $date;
    private \DateTime $due_date;
    private string $company_id;
    private string $status;
    private ?\DateTime $created_at;
    private ?\DateTime $updated_at;

    public function __construct(
        string $id,
        string $number,
        \DateTime $date,
        \DateTime $due_date,
        string $company_id,
        string $status,
        ?\DateTime $created_at = null,
        ?\DateTime $updated_at = null
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->date = $date;
        $this->due_date = $due_date;
        $this->company_id = $company_id;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getters and setters for each property
    public function getId(): string
    {
        return $this->id;
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

    public function getCompanyId(): string
    {
        return $this->company_id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }
}
