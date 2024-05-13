<?php

declare(strict_types=1);

namespace Tests\Feature\App\Modules\Invoices\Infrastructure\Listeners;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Infrastructure\Model\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InvoiceEventSubscriberTest extends TestCase
{
    use RefreshDatabase;

    public function test_approve_invoice(): void
    {
        $invoice = Invoice::factory()->create();

        /** @var ApprovalFacadeInterface $testObj */
        $testObj = app(ApprovalFacadeInterface::class);
        $testObj->approve(new ApprovalDto(
            Uuid::fromString($invoice->id),
            $invoice->status,
            \App\Modules\Invoices\Domain\Invoice::class
        ));

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => StatusEnum::APPROVED,
        ]);
    }

    public function test_reject_invoice(): void
    {
        $invoice = Invoice::factory()->create();

        /** @var ApprovalFacadeInterface $testObj */
        $testObj = app(ApprovalFacadeInterface::class);
        $testObj->reject(new ApprovalDto(
            Uuid::fromString($invoice->id),
            $invoice->status,
            \App\Modules\Invoices\Domain\Invoice::class
        ));

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => StatusEnum::REJECTED,
        ]);
    }

    public function test_cant_change_invoice_approval(): void
    {
        $this->expectException(\DomainException::class);

        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::REJECTED,
        ]);

        /** @var ApprovalFacadeInterface $testObj */
        $testObj = app(ApprovalFacadeInterface::class);
        $testObj->approve(new ApprovalDto(
            Uuid::fromString($invoice->id),
            StatusEnum::DRAFT,
            \App\Modules\Invoices\Domain\Invoice::class
        ));

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => StatusEnum::REJECTED,
        ]);
    }
}
