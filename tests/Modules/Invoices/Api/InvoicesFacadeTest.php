<?php

namespace Tests\Modules\Invoices\Api;

use App\Modules\Invoices\Api\InvoicesFacade;
use App\Modules\Invoices\Application\InvoicesRepositoryInterface;
use PHPUnit\Framework\TestCase;

class InvoicesFacadeTest extends TestCase
{
    private InvoicesRepositoryInterface $invoicesRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->invoicesRepository = $this->createMock(InvoicesRepositoryInterface::class);
    }
    public function testListReturnsArrayOfInvoices()
    {
        $invoicesFacade = new InvoicesFacade($this->invoicesRepository);

        // Define a sample list of invoices that you expect to be returned
        $sampleInvoices = [
            [],
            [],
            [],
        ];

        // Configure the mock to return the sample invoices
        $this->invoicesRepository
            ->expects($this->once())
            ->method('getAll')
            ->willReturn($sampleInvoices);

        // Assert that the method returns the sample invoices
        $this->assertEquals($sampleInvoices, $invoicesFacade->list());
    }

    public function testGet()
    {

    }

    public function testReject()
    {

    }

    public function testApprove()
    {

    }
}
