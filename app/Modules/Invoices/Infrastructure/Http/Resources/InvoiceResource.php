<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class InvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'invoice_number' => $this->number,
            'invoice_date' => $this->date,
            'due_date' => $this->due_date,
            'company' => new CompanyResource($this->company),
            'billed_company' => new BilledCompanyResource($this->company),
            'products' => (new ProductCollection($this->products)),
            'total_price' => (string) $this->totalPrice(),
        ];
    }
}
