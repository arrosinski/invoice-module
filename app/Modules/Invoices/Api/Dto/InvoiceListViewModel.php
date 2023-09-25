<?php

namespace App\Modules\Invoices\Api\Dto;

use App\Infrastructure\Traits\ToArray;
use App\Infrastructure\Traits\ToArrayTrait;

#[ToArray]
class InvoiceListViewModel
{
    use ToArrayTrait;
    public string $id;
    public string $number;
    public string $date;
    public string $dueDate;
    public string $status;
    public string $createdAt;
    public string $updatedAt;
    public array $_links;

    /**
     * @param string $id
     * @param string $number
     * @param string $date
     * @param string $dueDate
     * @param string $status
     * @param string $createdAt
     * @param string $updatedAt
     * @param array $_links
     */
    public function __construct(string $id, string $number, string $date, string $dueDate, string $status, string $createdAt, string $updatedAt, array $_links = [])
    {
        $this->id = $id;
        $this->number = $number;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->_links = $_links;
    }

    public static function fromArray(array|object $data, array $links): InvoiceListViewModel
    {
        $array = (array) $data;
        return new self(
            $array['id'],
            $array['number'],
            $array['date'],
            $array['due_date'],
            $array['status'],
            $array['created_at'],
            $array['updated_at'],
            $links,
        );
    }



}
