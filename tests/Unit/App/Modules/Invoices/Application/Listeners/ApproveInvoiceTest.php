<?php

declare(strict_types=1);

namespace Tests\Unit\App\Modules\Invoices\Application\Listeners;

use App\Domain\Enums\StatusEnum;
use App\Domain\ValueObjects\Money;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Invoices\Application\InvoiceInMemoryRepository;
use App\Modules\Invoices\Application\Listeners\ApproveInvoice;
use App\Modules\Invoices\Domain\Invoice;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class ApproveInvoiceTest extends TestCase
{
    public function test_approve_invoice(): void
    {
        $invoice = new Invoice(Uuid::uuid4());
        $repository = new InvoiceInMemoryRepository($invoice);

        $event = new EntityApproved(new ApprovalDto($invoice->id, StatusEnum::DRAFT, Invoice::class));

        $testObj = new ApproveInvoice($repository);
        $testObj($event);

        $this->assertTrue($invoice->isApproved());
    }

    public function test_skip_wrong_event(): void
    {
        $invoice = new Invoice(Uuid::uuid4());
        $repository = new InvoiceInMemoryRepository($invoice);
        $event = new EntityApproved(new ApprovalDto($invoice->id, StatusEnum::DRAFT, Money::class));

        $testObj = new ApproveInvoice($repository);
        $testObj($event);

        $this->assertFalse($invoice->isApproved());
        $this->assertFalse($invoice->isRejected());
    }
}
