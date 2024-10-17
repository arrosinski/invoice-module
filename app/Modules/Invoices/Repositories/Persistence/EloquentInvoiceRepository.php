<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Repositories\Persistence;

use App\Invoice as InvoiceModel;
use App\Company as CompanyModel;
use App\Modules\Invoices\Entities\Invoice as InvoiceEntity;
use App\Modules\Invoices\Entities\Company as CompanyEntity;
use App\Modules\Invoices\Repositories\InvoiceRepository;

class EloquentInvoiceRepository implements InvoiceRepository
{
    public function findAll(): array
    {
        $invoices = InvoiceModel::with('company')->get(['number', 'date', 'due_date', 'company_id']);

        return $invoices->map(function ($invoice) {
            $company = CompanyModel::find($invoice->company_id, ['name', 'street', 'city', 'zip', 'phone']);
            $companyEntity = new CompanyEntity(
                $company->name,
                $company->street,
                $company->city,
                $company->zip,
                $company->phone
            );

            return new InvoiceEntity(
                $invoice->number,
                new \DateTime($invoice->date),
                new \DateTime($invoice->due_date),
                $companyEntity
            );
        })->toArray();
    }
}
