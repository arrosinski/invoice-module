<?php

namespace App\Modules\Invoices\Domain\Entities;

use App\Domain\Enums\StatusEnum;
use Illuminate\Support\Collection;
use Ramsey\Uuid\UuidInterface;
use stdClass;

class Invoice
{
    private string $id;
    private UuidInterface $number;
    private string $date;
    private string $dueDate;
    private stdClass $company;
    private StatusEnum $status;
    private Collection $items;

    public function __construct(
        string $id,
        UuidInterface $number,
        string $date,
        string $dueDate,
        stdClass $company,
        StatusEnum $status,
        Collection $items,
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->company = $company;
        $this->status = $status;
        $this->items = $items;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNumber(): UuidInterface
    {
        return $this->number;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    public function getCompany(): stdClass
    {
        return $this->company;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

}
