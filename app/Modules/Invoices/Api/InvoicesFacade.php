<?php

namespace App\Modules\Invoices\Api;

use App\Modules\Invoices\Application\InvoicesFacadeInterface;
use App\Modules\Invoices\Application\InvoicesRepositoryInterface;
use App\Modules\Invoices\Domain\Invoice;

class InvoicesFacade implements InvoicesFacadeInterface
{
    private InvoicesRepositoryInterface $invoicesRepository;

    public function __construct(InvoicesRepositoryInterface $invoicesRepository)
    {
        $this->invoicesRepository = $invoicesRepository;
    }

    public function list(): array
    {
        return $this->invoicesRepository->getAll();
    }

    public function get(string $id): Invoice
    {
        return $this->invoicesRepository->get($id);
    }

    public function can_approve(string $id): bool
    {
        return $this->get($id)->can_approve();
    }
}
