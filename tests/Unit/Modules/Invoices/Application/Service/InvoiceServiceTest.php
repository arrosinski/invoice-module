<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Application\Service;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Application\Exception\InvoiceNotFoundException;
use App\Modules\Invoices\Application\Mapper\InvoiceMapper;
use App\Modules\Invoices\Application\Service\InvoiceService;
use App\Modules\Invoices\Domain\Entity\Company;
use App\Modules\Invoices\Domain\Entity\Invoice;
use App\Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\CreatesApplication;

final class InvoiceServiceTest extends TestCase
{
    use CreatesApplication;

    private MockObject $invoiceRepository;

    private MockObject $approvalService;

    private InvoiceService $invoiceService;

    /**
     * @throws InvoiceNotFoundException
     * @throws \Exception
     */
    public function testInfoWhenInvoiceIsNotFound(): void
    {
        $id = Uuid::uuid1();

        $this->invoiceRepository->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $this->expectException(InvoiceNotFoundException::class);
        $this->expectExceptionMessage('Approval cannot be performed because the invoice could not be found');

        $this->invoiceService->info($id);
    }

    /**
     * @throws InvoiceNotFoundException
     * @throws \Exception
     */
    public function testInfo(): void
    {
        $id = Uuid::uuid1();

        $companyId = Uuid::uuid1();
        $name = uniqid('name-');
        $street = uniqid('street-');
        $city = uniqid('city-');
        $zip = uniqid('zip-');
        $phone = uniqid('phone-');
        $email = uniqid('email-');

        $company = new Company(
            $companyId,
            $name,
            $street,
            $city,
            $zip,
            $phone,
            $email,
        );

        $number = Uuid::uuid1();
        $date = new \DateTimeImmutable();
        $dueDate = new \DateTimeImmutable();
        $status = StatusEnum::DRAFT;

        $invoice = new Invoice(
            $id,
            $number,
            $date,
            $dueDate,
            $status,
        );

        $invoice->setCompany($company);

        $this->invoiceRepository->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($invoice);

        $expected = InvoiceMapper::fromEntityToDto($invoice);

        $this->assertEquals($expected, $this->invoiceService->info($id));
    }

    /**
     * @throws InvoiceNotFoundException
     * @throws \LogicException
     */
    public function testApproveWhenInvoiceIsNotFound(): void
    {
        $id = Uuid::uuid1();

        $this->invoiceRepository->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $this->approvalService->expects($this->never())->method($this->anything());
        $this->invoiceRepository->expects($this->never())->method('update');

        $this->expectException(InvoiceNotFoundException::class);
        $this->expectExceptionMessage('Approval cannot be performed because the invoice could not be found');

        $this->invoiceService->approve($id);
    }

    /**
     * @throws InvoiceNotFoundException
     * @throws \LogicException
     */
    public function testApprove(): void
    {
        $id = Uuid::uuid1();

        $companyId = Uuid::uuid1();
        $name = uniqid('name-');
        $street = uniqid('street-');
        $city = uniqid('city-');
        $zip = uniqid('zip-');
        $phone = uniqid('phone-');
        $email = uniqid('email-');

        $company = new Company(
            $companyId,
            $name,
            $street,
            $city,
            $zip,
            $phone,
            $email,
        );

        $number = Uuid::uuid1();
        $date = new \DateTimeImmutable();
        $dueDate = new \DateTimeImmutable();
        $status = StatusEnum::DRAFT;

        $invoice = new Invoice(
            $id,
            $number,
            $date,
            $dueDate,
            $status,
        );

        $invoice->setCompany($company);

        $this->invoiceRepository->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($invoice);

        $approval = new ApprovalDto($id, StatusEnum::DRAFT, Invoice::class);

        $this->approvalService->expects($this->once())
            ->method('approve')
            ->with($approval);

        $this->invoiceRepository->expects($this->once())
            ->method('update')
            ->with($invoice);

        $this->invoiceService->approve($id);

        $this->assertSame(StatusEnum::APPROVED, $invoice->getStatus());
    }

    /**
     * @throws InvoiceNotFoundException
     * @throws \LogicException
     */
    public function testRejectWhenInvoiceIsNotFound(): void
    {
        $id = Uuid::uuid1();

        $this->invoiceRepository->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $this->approvalService->expects($this->never())->method($this->anything());
        $this->invoiceRepository->expects($this->never())->method('update');

        $this->expectException(InvoiceNotFoundException::class);
        $this->expectExceptionMessage('Approval cannot be performed because the invoice could not be found');

        $this->invoiceService->reject($id);
    }

    /**
     * @throws InvoiceNotFoundException
     * @throws \LogicException
     */
    public function testReject(): void
    {
        $id = Uuid::uuid1();

        $companyId = Uuid::uuid1();
        $name = uniqid('name-');
        $street = uniqid('street-');
        $city = uniqid('city-');
        $zip = uniqid('zip-');
        $phone = uniqid('phone-');
        $email = uniqid('email-');

        $company = new Company(
            $companyId,
            $name,
            $street,
            $city,
            $zip,
            $phone,
            $email,
        );

        $number = Uuid::uuid1();
        $date = new \DateTimeImmutable();
        $dueDate = new \DateTimeImmutable();
        $status = StatusEnum::DRAFT;

        $invoice = new Invoice(
            $id,
            $number,
            $date,
            $dueDate,
            $status,
        );

        $invoice->setCompany($company);

        $this->invoiceRepository->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($invoice);

        $approval = new ApprovalDto($id, StatusEnum::DRAFT, Invoice::class);

        $this->approvalService->expects($this->once())
            ->method('reject')
            ->with($approval);

        $this->invoiceRepository->expects($this->once())
            ->method('update')
            ->with($invoice);

        $this->invoiceService->reject($id);

        $this->assertSame(StatusEnum::REJECTED, $invoice->getStatus());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->createApplication();

        $this->invoiceRepository = $this->createMock(InvoiceRepositoryInterface::class);
        $this->approvalService = $this->createMock(ApprovalFacadeInterface::class);

        $this->invoiceService = new InvoiceService(
            $this->invoiceRepository,
            $this->approvalService
        );
    }
}
