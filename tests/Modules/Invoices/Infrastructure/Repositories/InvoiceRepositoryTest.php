<?php

declare(strict_types=1);

namespace Tests\Modules\Invoices\Infrastructure\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Infrastructure\Database\Seeders\DatabaseSeeder;
use App\Modules\Invoices\Infrastructure\Repositories\InvoiceRepository;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use Tests\Traits\FindInvoiceTrait;

class InvoiceRepositoryTest extends TestCase
{
    use FindInvoiceTrait;

    private InvoiceRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->repository = $this->app->get(InvoiceRepository::class);
    }

    public function testFindById(): void
    {
        $uuid = $this->findFirst(StatusEnum::APPROVED)->id;
        $invoice = $this->repository->findById(Uuid::fromString($uuid));

        $this->assertNotNull($invoice);
        $this->assertSame(StatusEnum::APPROVED, $invoice->status);
    }
}
