<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Repositories\Persistence;

use App\Company as CompanyModel;
use App\Invoice as InvoiceModel;
use App\Modules\Invoices\Entities\ApprovalInvoice as ApprovalInvoiceEntity;
use App\Modules\Invoices\Entities\BilledCompany as BilledCompanyEntity;
use App\Modules\Invoices\Entities\Company as CompanyEntity;
use App\Modules\Invoices\Entities\Invoice as InvoiceEntity;
use App\Modules\Invoices\Entities\Product as ProductEntity;
use App\Modules\Invoices\Entities\ProductCollection;
use App\Modules\Invoices\Repositories\InvoiceRepository;
use App\Modules\Invoices\Services\TotalPriceCountingService;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class EloquentInvoiceRepository implements InvoiceRepository
{
    private $totalPriceCountingService;

    public function __construct(TotalPriceCountingService $totalPriceCountingService)
    {
        $this->totalPriceCountingService = $totalPriceCountingService;
    }

    public function findById(UuidInterface $id): ?ApprovalInvoiceEntity
    {
        $invoiceModel = InvoiceModel::find($id->toString());
        return $invoiceModel ? $this->mapToApprovalEntity($invoiceModel) : null;
    }

    public function findAll(): array
    {
        $invoices = InvoiceModel::with(['company', 'billedCompany', 'products'])
            ->get(['id', 'number', 'date', 'due_date', 'company_id', 'billed_company_id']);

        return $invoices->map(function ($invoice) {
            return $this->mapToInvoiceEntity($invoice);
        })->toArray();
    }

    public function save(InvoiceEntity $invoice): void
    {
        $invoiceModel = InvoiceModel::find($invoice->getNumber()->toString());

        if ($invoiceModel) {
            $invoiceModel->date = $invoice->getDate()->format('Y-m-d');
            $invoiceModel->due_date = $invoice->getDueDate()->format('Y-m-d');
            $invoiceModel->company_id = $invoice->getCompany()->getId();
            $invoiceModel->billed_company_id = $invoice->getBilledCompany()->getId();
        } else {
            $invoiceModel = new InvoiceModel();
            $invoiceModel->number = $invoice->getNumber()->toString();
            $invoiceModel->date = $invoice->getDate()->format('Y-m-d');
            $invoiceModel->due_date = $invoice->getDueDate()->format('Y-m-d');
            $invoiceModel->company_id = $invoice->getCompany()->getId();
            $invoiceModel->billed_company_id = $invoice->getBilledCompany()->getId();
        }

        $invoiceModel->save();
    }

    private function mapToInvoiceEntity(InvoiceModel $invoiceModel): InvoiceEntity
    {
        $company = CompanyModel::find($invoiceModel->company_id, ['id', 'name', 'street', 'city', 'zip', 'phone']);
        $companyEntity = new CompanyEntity(
            (string) $company->id, // Cast id to string
            $company->name,
            $company->street,
            $company->city,
            $company->zip,
            $company->phone
        );

        $billedCompany = CompanyModel::find(
            $invoiceModel->billed_company_id,
            ['id', 'name', 'street', 'city', 'zip', 'phone', 'email']
        );
        $billedCompanyEntity = new BilledCompanyEntity(
            (string) $billedCompany->id, // Cast id to string
            $billedCompany->name,
            $billedCompany->street,
            $billedCompany->city,
            $billedCompany->zip,
            $billedCompany->phone,
            $billedCompany->email
        );

        $products = new ProductCollection();
        foreach ($invoiceModel->products as $product) {
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
            Uuid::fromString($invoiceModel->number),
            new \DateTime($invoiceModel->date),
            new \DateTime($invoiceModel->due_date),
            $companyEntity,
            $billedCompanyEntity,
            $products,
            $totalPrice
        );
    }

    private function mapToApprovalEntity(InvoiceModel $invoiceModel): ApprovalInvoiceEntity
    {
        $company = CompanyModel::find($invoiceModel->company_id, ['id', 'name', 'street', 'city', 'zip', 'phone']);
        $companyEntity = new CompanyEntity(
            (string) $company->id, // Cast id to string
            $company->name,
            $company->street,
            $company->city,
            $company->zip,
            $company->phone
        );

        $billedCompany = CompanyModel::find(
            $invoiceModel->billed_company_id,
            ['id', 'name', 'street', 'city', 'zip', 'phone', 'email']
        );
        $billedCompanyEntity = new BilledCompanyEntity(
            (string) $billedCompany->id, // Cast id to string
            $billedCompany->name,
            $billedCompany->street,
            $billedCompany->city,
            $billedCompany->zip,
            $billedCompany->phone,
            $billedCompany->email
        );

        $products = new ProductCollection();
        foreach ($invoiceModel->products as $product) {
            $quantity = $product->pivot->quantity;
            $price = $product->price;
            $products->addProduct(new ProductEntity(
                $product->name,
                $price,
                $quantity
            ));
        }

        $totalPrice = $this->totalPriceCountingService->calculateTotalPrice($products);

        return new ApprovalInvoiceEntity(
            Uuid::fromString($invoiceModel->number),
            new \DateTime($invoiceModel->date),
            new \DateTime($invoiceModel->due_date),
            $companyEntity,
            $billedCompanyEntity,
            $products,
            $totalPrice,
            $invoiceModel->status,
            $invoiceModel->approval_status
        );
    }
}
