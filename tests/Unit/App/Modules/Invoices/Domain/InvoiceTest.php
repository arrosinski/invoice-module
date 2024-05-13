<?php

declare(strict_types=1);

namespace Tests\Unit\App\Modules\Invoices\Domain;

use App\Modules\Invoices\Domain\Invoice;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class InvoiceTest extends TestCase
{
    private Invoice $testObj;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testObj = new Invoice(Uuid::uuid4());
    }

    public function test_approve_invoice(): void
    {
        $this->testObj->approve();

        $this->assertTrue($this->testObj->isApproved());
    }

    public function test_reject_invoice(): void
    {
        $this->testObj->reject();

        $this->assertTrue($this->testObj->isRejected());
    }

    public function test_status_immutability_approved(): void
    {
        $this->expectException(\DomainException::class);

        $this->testObj->approve();
        $this->testObj->reject();
    }

    public function test_status_immutability_rejected(): void
    {
        $this->expectException(\DomainException::class);

        $this->testObj->reject();
        $this->testObj->approve();
    }
}
