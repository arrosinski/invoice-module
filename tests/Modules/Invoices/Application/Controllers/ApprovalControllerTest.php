<?php

declare(strict_types=1);

namespace Tests\Modules\Invoices\Application\Controllers;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Infrastructure\Database\Seeders\DatabaseSeeder;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\Traits\FindInvoiceTrait;

class ApprovalControllerTest extends TestCase
{
    use FindInvoiceTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * @dataProvider invoiceProvider
     */
    public function testApprove(StatusEnum $status, int $statusCode): void
    {
        $uuid = $this->findFirst($status)->id;
        $invoice = $this->post(route('invoices.approve', $uuid));

        $this->assertSame($statusCode, $invoice->getStatusCode());
    }

    public function testNotFoundOnApproval(): void
    {
        $uuid = UUID::NIL;
        $invoice = $this->post(route('invoices.approve', $uuid));

        $this->assertSame(Response::HTTP_NOT_FOUND, $invoice->getStatusCode());
    }

    /**
     * @dataProvider invoiceProvider
     */
    public function testReject(StatusEnum $status, int $statusCode): void
    {
        $uuid = $this->findFirst($status)->id;
        $invoice = $this->post(route('invoices.reject', $uuid));

        $this->assertSame($statusCode, $invoice->getStatusCode());
    }

    public function testNotFoundOnReject(): void
    {
        $uuid = UUID::NIL;
        $invoice = $this->post(route('invoices.reject', $uuid));

        $this->assertSame(Response::HTTP_NOT_FOUND, $invoice->getStatusCode());
    }

    /**
     * @return iterable<array{StatusEnum, int}>
     */
    public function invoiceProvider(): iterable
    {
        yield [StatusEnum::DRAFT, Response::HTTP_OK];
        yield [StatusEnum::APPROVED, Response::HTTP_UNPROCESSABLE_ENTITY];
        yield [StatusEnum::REJECTED, Response::HTTP_UNPROCESSABLE_ENTITY];
    }
}
