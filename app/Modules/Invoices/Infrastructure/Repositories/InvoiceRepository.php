<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Repositories;

use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepository as RepositoryContract;
use App\Modules\Invoices\Infrastructure\DataMappers\InvoiceMapper;
use Illuminate\Database\ConnectionInterface;
use Ramsey\Uuid\UuidInterface;

readonly class InvoiceRepository implements RepositoryContract
{
    public function __construct(
        private ConnectionInterface $db,
        private InvoiceMapper $mapper
    ) {
    }

    public function findById(UuidInterface $uuid): ?Invoice
    {
        $invoice = $this->db
            ->table('invoices')
            ->find($uuid->toString());

        if ($invoice === null) {
            return null;
        }

        $company = $this->db
            ->table('companies')
            ->find($invoice->company_id);

        $products = $this->db
            ->table('products')
            ->join('invoice_product_lines', 'products.id', 'product_id')
            ->where('invoice_id', $invoice->id)
            ->get(['products.*', 'invoice_product_lines.quantity']);

        return $this->mapper->map($invoice, $company, $company, $products);
    }
}
