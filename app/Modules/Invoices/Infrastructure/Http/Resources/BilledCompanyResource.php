<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Resources;

final class BilledCompanyResource  extends CompanyResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'email_address' => $this->email,
        ]);
    }
}
