<?php

namespace App\Modules\Invoices\Infrastructure\Listeners;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Invoices\Application\InvoicesFacadeInterface;
use App\Modules\Invoices\Domain\Entities\Invoice;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

readonly class InvoiceApprovedListener
{
    public function __construct(private InvoicesFacadeInterface $invoicesFacade)
    {
    }

    public function handle(EntityApproved $event): void
    {
        if (!$this->validate($event)) {
            return;
        }
        $this->invoicesFacade->approve($event->approvalDto->id);
    }

    private function validate(EntityApproved $event): bool
    {
        if (!class_exists($event->approvalDto->entity)) {
            throw new InvalidArgumentException('Invalid entity class');
        }
        if ($event->approvalDto->entity !== Invoice::class) {
            return false;
        }
        return true;
    }
}
