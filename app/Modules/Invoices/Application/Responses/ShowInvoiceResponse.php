<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Responses;

use App\Modules\Invoices\Domain\Models\Company;
use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Domain\Models\Product;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowInvoiceResponse extends JsonResponse
{
    public function __construct(Invoice $invoice)
    {
        parent::__construct($this->transform($invoice));
    }

    /**
     * @return array<string, mixed>
     */
    private function transform(Invoice $invoice): array
    {
        return [
            'id' => $invoice->uuid->toString(),
            'number' => $invoice->number,
            'date' => $invoice->date->format(DATE_ATOM),
            'due_date' => $invoice->dueDate->format(DATE_ATOM),
            'status' => $invoice->status->value,
            'total_price' => $invoice->totalPrice(),
            'company' => $this->transformCompany($invoice->company),
            'billed_company' => $this->transformBillingCompany($invoice->billingCompany),
            'products' => $invoice->products->map(fn(Product $product) => $this->transformProduct($product)),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function transformBillingCompany(Company $company): array
    {
        $transformed = $this->transformCompany($company);
        $transformed['email'] = $company->email;

        return $transformed;
    }

    /**
     * @return array<string, mixed>
     */
    private function transformCompany(Company $company): array
    {
        return [
            'name' => $company->name,
            'street_address' => $company->streetAddress,
            'city' => $company->city,
            'zip_code' => $company->zipCode,
            'phone_number' => $company->phoneNumber,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function transformProduct(Product $product): array
    {
        return [
            'name' => $product->name,
            'quantity' => $product->quantity,
            'unitPrice' => $product->unitPrice,
            'totalPrice' => $product->totalPrice(),
        ];
    }
}
