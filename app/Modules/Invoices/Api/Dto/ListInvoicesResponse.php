<?php

namespace App\Modules\Invoices\Api\Dto;

use App\Infrastructure\HateoasResponse;

class ListInvoicesResponse
{
    private HateoasResponse $response;
    private array $invoices;

    public function __construct(
        array $invoices
    ) {
        $this->response = HateoasResponse::create();
        $this->invoices = $invoices;
    }
}
