<?php

namespace Tests\Modules\Invoices\Api;

use App\Modules\Invoices\Api\InvoicesFacade;
use App\Modules\Invoices\Application\InvoicesRepositoryInterface;
use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Infrastructure\Database\Factories\InvoiceFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoicesFacadeTest extends TestCase
{
    use RefreshDatabase;
    private InvoicesRepositoryInterface $invoicesRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->invoicesRepository = $this->createMock(InvoicesRepositoryInterface::class);
    }
    public function testListReturnsArrayOfInvoices()
    {
        $invoicesFacade = new InvoicesFacade($this->invoicesRepository);

        $sampleInvoices = [
            InvoiceFactory::new()->make(),
            InvoiceFactory::new()->make(),
            InvoiceFactory::new()->make(),

        ];

        // Configure the mock to return the sample invoices
        $this->invoicesRepository
            ->expects($this->once())
            ->method('getAll')
            ->willReturn($sampleInvoices);

        // Assert that the method returns the sample invoices
        $this->assertEquals($sampleInvoices, $invoicesFacade->list());
    }

    public function testGetReturnsInvoice()
    {
        $invoicesFacade = new InvoicesFacade($this->invoicesRepository);
        $invoiceId = '1';

        // Define a sample invoice that you expect to be returned
        $invoiceDao = InvoiceFactory::new()->make();
        $invoice = Invoice::builder()->fromArray($invoiceDao->toArray())->build();

        // Configure the mock to return the sample invoice
        $this->invoicesRepository
            ->expects($this->once())
            ->method('get')
            ->with($invoiceId)
            ->willReturn($invoice);

        // Assert that the method returns the sample invoice
        $this->assertEquals($invoice, $invoicesFacade->get($invoiceId));
    }


}
