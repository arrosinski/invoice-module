<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Modules\Invoices\Domain\Invoice;
use Ramsey\Uuid\UuidInterface;

final class InvoiceInMemoryRepository implements InvoiceRepositoryInterface
{
    /** @var array<string, Invoice>  */
    private array $invoices;

    public function __construct(
        Invoice ...$invoices
    ) {
        foreach ($invoices as $invoice) {
            $this->save($invoice);
        }
    }

    public function get(UuidInterface $id): Invoice
    {
        return $this->invoices[(string)$id];
    }

    public function save(Invoice $invoice): void
    {
        $this->invoices[(string)$invoice->id] = $invoice;
    }
}
