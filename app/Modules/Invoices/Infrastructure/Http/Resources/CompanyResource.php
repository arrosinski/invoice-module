<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource  extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'street_address' => $this->street,
            'city' => $this->city,
            'zip_code' => $this->zip,
            'phone' => $this->phone,
        ];
    }
}
