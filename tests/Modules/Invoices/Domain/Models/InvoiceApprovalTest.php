<?php

declare(strict_types=1);

namespace Tests\Modules\Invoices\Domain\Models;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Invoices\Domain\Models\InvoiceApproval;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class InvoiceApprovalTest extends TestCase
{
    public function testApprove(): void
    {
        $invoiceApproval = new InvoiceApproval(Uuid::uuid4(), StatusEnum::DRAFT);
        $facade = $this->createMock(ApprovalFacadeInterface::class);
        $facade->expects(self::once())->method('approve');

        $invoiceApproval->approve($facade);
    }

    public function testReject(): void
    {
        $invoiceApproval = new InvoiceApproval(Uuid::uuid4(), StatusEnum::DRAFT);
        $facade = $this->createMock(ApprovalFacadeInterface::class);
        $facade->expects(self::once())->method('reject');

        $invoiceApproval->reject($facade);
    }
}
