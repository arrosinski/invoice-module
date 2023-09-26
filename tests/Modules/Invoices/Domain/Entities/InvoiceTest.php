<?php

namespace Tests\Modules\Invoices\Domain\Entities;

use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Domain\ValueObjects\StatusEnum;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{

    protected Invoice $invoice;
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testIfBuiltCorrectly()
    {
        $this->invoice = Invoice::builder()->fromArray([
            'id' => '123',
            'number' => '123',
            'date' => '2021-01-01',
            'status' => StatusEnum::APPROVED->value,
            ])
            ->build();

        $this->assertEquals('123', $this->invoice->id);
        $this->assertEquals('123', $this->invoice->number);
        $this->assertEquals('2021-01-01', $this->invoice->date);
        $this->assertEquals(StatusEnum::APPROVED, $this->invoice->status);
    }

    public function testStatusNotApprovable()
    {
        $this->invoice = Invoice::builder()->fromArray([
            'id' => '123',
            'number' => '123',
            'date' => '2021-01-01',
            'status' => StatusEnum::APPROVED->value,
            ])
            ->build();

        $this->assertEquals(false, $this->invoice->canApprove());
        $this->assertEquals(false, $this->invoice->canReject());
    }


    public function testStatusNotApprovable2()
    {
        $this->invoice = Invoice::builder()->fromArray([
            'id' => '123',
            'number' => '123',
            'date' => '2021-01-01',
            'status' => StatusEnum::REJECTED->value,
            ])
            ->build();

        $this->assertEquals(false, $this->invoice->canApprove());
        $this->assertEquals(false, $this->invoice->canReject());
    }

    public function testStatusApprovable()
    {
        $this->invoice = Invoice::builder()->fromArray([
            'id' => '123',
            'number' => '123',
            'date' => '2021-01-01',
            'status' => StatusEnum::DRAFT->value,
            ])
            ->build();

        $this->assertEquals(true, $this->invoice->canApprove());
        $this->assertEquals(true, $this->invoice->canReject());
    }


}
