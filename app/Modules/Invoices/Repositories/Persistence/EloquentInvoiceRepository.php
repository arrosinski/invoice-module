<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Repositories\Persistence;

use App\Company as CompanyModel;
use App\Invoice as InvoiceModel;
use App\Modules\Invoices\Entities\BilledCompany as BilledCompanyEntity;
use App\Modules\Invoices\Entities\Company as CompanyEntity;
use App\Modules\Invoices\Entities\Invoice as InvoiceEntity;
use App\Modules\Invoices\Entities\Product as ProductEntity;
use App\Modules\Invoices\Entities\ProductCollection;
use App\Modules\Invoices\Repositories\InvoiceRepository;

class EloquentInvoiceRepository implements InvoiceRepository
{
    public function findAll(): array
    {
        $invoices = InvoiceModel::with(['company', 'billedCompany', 'products'])
            ->get(['number', 'date', 'due_date', 'company_id', 'billed_company_id']);

        return $invoices->map(function ($invoice) {
            $company = CompanyModel::find($invoice->company_id, ['name', 'street', 'city', 'zip', 'phone']);
            $companyEntity = new CompanyEntity(
                $company->name,
                $company->street,
                $company->city,
                $company->zip,
                $company->phone
            );

            $billedCompany = CompanyModel::find(
                $invoice->billed_company_id,
                ['name', 'street', 'city', 'zip', 'phone', 'email']
            );
            $billedCompanyEntity = new BilledCompanyEntity(
                $billedCompany->name,
                $billedCompany->street,
                $billedCompany->city,
                $billedCompany->zip,
                $billedCompany->phone,
                $billedCompany->email
            );

            $products = new ProductCollection();
            foreach ($invoice->products as $product) {
                $quantity = $product->pivot->quantity;
                $price = $product->price;
                $total = $price * $quantity;

                $products->addProduct(new ProductEntity(
                    $product->name,
                    $price,
                    $quantity,
                    $total
                ));
            }

            return new InvoiceEntity(
                $invoice->number,
                new \DateTime($invoice->date),
                new \DateTime($invoice->due_date),
                $companyEntity,
                $billedCompanyEntity,
                $products
            );
        })->toArray();
    }
}
