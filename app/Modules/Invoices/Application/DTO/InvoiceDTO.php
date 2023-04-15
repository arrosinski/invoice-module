<?php

namespace App\Modules\Invoices\Application\DTO;

use App\Domain\Enums\StatusEnum;
use Illuminate\Support\Collection;
use Ramsey\Uuid\UuidInterface;
use stdClass;

class InvoiceDTO
{
    private $id;
    private $number;
    private $date;
    private $dueDate;
    private $company;
    private $status;
    private $items;

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

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'number' => $this->getNumber(),
            'date' => $this->getDate(),
            'due_date' => $this->getDueDate(),
            'company' => $this->getCompany(),
            'status' => $this->getStatus(),
            'items' => $this->getItems(),
        ];
    }
}