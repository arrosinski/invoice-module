<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Resources;

use App\Modules\Invoices\Api\Dto\InvoiceDto;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var InvoiceDto $invoiceDto */
        $invoiceDto = $this->resource;

        return [
            //@todo map dto to resource
        ];
    }
}
