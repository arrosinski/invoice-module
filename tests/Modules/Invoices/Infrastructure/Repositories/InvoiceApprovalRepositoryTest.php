<?php

declare(strict_types=1);

namespace Tests\Modules\Invoices\Infrastructure\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Models\InvoiceApproval;
use App\Modules\Invoices\Infrastructure\Database\Seeders\DatabaseSeeder;
use App\Modules\Invoices\Infrastructure\Repositories\InvoiceApprovalRepository;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use Tests\Traits\FindInvoiceTrait;

class InvoiceApprovalRepositoryTest extends TestCase
{
    use FindInvoiceTrait;

    private InvoiceApprovalRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->repository = $this->app->get(InvoiceApprovalRepository::class);
    }

    public function testFindById(): void
    {
        $uuid = Uuid::fromString($this->findFirst(StatusEnum::DRAFT)->id);
        $invoice = $this->repository->findById($uuid);

        $this->assertNotNull($invoice);
        $this->assertSame(StatusEnum::DRAFT, $invoice->getStatus());
    }

    public function testUpdate(): void
    {
        $uuid = Uuid::fromString($this->findFirst(StatusEnum::DRAFT)->id);

        $this->repository->update(new InvoiceApproval($uuid, StatusEnum::APPROVED));
        $invoice = $this->repository->findById($uuid);

        $this->assertNotNull($invoice);
        $this->assertSame(StatusEnum::APPROVED, $invoice->getStatus());
    }

    public function testNotFoundById(): void
    {
        $uuid = Uuid::fromString(Uuid::NIL);
        $this->assertNull($this->repository->findById($uuid));
    }
}
