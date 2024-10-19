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
use App\Modules\Invoices\Services\TotalPriceCountingService;
use Illuminate\Support\Facades\Log;

class EloquentInvoiceRepository implements InvoiceRepository
{
    private $totalPriceCountingService;

    public function __construct(TotalPriceCountingService $totalPriceCountingService)
    {
        $this->totalPriceCountingService = $totalPriceCountingService;
    }

    public function findAll(): array
    {
        $invoices = InvoiceModel::with(['company', 'billedCompany', 'products'])
            ->get(['id', 'number', 'date', 'due_date', 'company_id', 'billed_company_id']);

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
                $products->addProduct(new ProductEntity(
                    $product->name,
                    $price,
                    $quantity
                ));
            }

            $totalPrice = $this->totalPriceCountingService->calculateTotalPrice($products);

            return new InvoiceEntity(
                $invoice->number,
                new \DateTime($invoice->date),
                new \DateTime($invoice->due_date),
                $companyEntity,
                $billedCompanyEntity,
                $products,
                $totalPrice
            );
        })->toArray();
    }
}
