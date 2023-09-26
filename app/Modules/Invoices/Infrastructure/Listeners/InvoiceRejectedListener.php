<?php

namespace App\Modules\Invoices\Infrastructure\Listeners;

use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Application\InvoicesFacadeInterface;
use App\Modules\Invoices\Domain\Entities\Invoice;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

readonly class InvoiceRejectedListener
{
     public function __construct(private InvoicesFacadeInterface $invoicesFacade)
    {
    }
    public function handle(EntityRejected $event): void
    {
        Log::debug('InvoiceRejectedListener');
        if (!$this->validate($event)) {
            return;
        }
        $this->invoicesFacade->reject($event->approvalDto->id);
    }

        private function validate(EntityRejected $event): bool
    {
        if (!class_exists($event->approvalDto->entity)) {
            throw new InvalidArgumentException('Invalid entity class');
        }
        if (!is_subclass_of($event->approvalDto->entity, Invoice::class)) {
            return false;
        }
        return true;
    }
}
