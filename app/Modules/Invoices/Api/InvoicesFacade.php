<?php

namespace App\Modules\Invoices\Api;

use App\Modules\Invoices\Application\InvoicesFacadeInterface;
use App\Modules\Invoices\Application\InvoicesRepositoryInterface;
use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Domain\Policies\CanChangeStatusPolicy;

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

    public function approve(string $id): void
    {
        $invoice = $this->invoicesRepository->get($id);
        CanChangeStatusPolicy::except($invoice);
        $this->invoicesRepository->approve($id);
    }

    public function reject(string $id): void
    {
        $invoice = $this->invoicesRepository->get($id);
        CanChangeStatusPolicy::except($invoice);
        $this->invoicesRepository->reject($id);
    }
}
