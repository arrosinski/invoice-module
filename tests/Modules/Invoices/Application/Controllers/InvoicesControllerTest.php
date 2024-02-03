<?php

declare(strict_types=1);

namespace Tests\Modules\Invoices\Application\Controllers;

use App\Modules\Invoices\Infrastructure\Database\Seeders\DatabaseSeeder;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\Traits\FindInvoiceTrait;

class InvoicesControllerTest extends TestCase
{
    use FindInvoiceTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function testShow(): void
    {
        $invoice = $this->findFirst();
        $response = $this->get(route('invoices.show', $invoice->id));

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame($invoice->id, $response->json()['id']);
        $this->assertSame($invoice->status, $response->json()['status']);
    }

    public function testNotFound(): void
    {
        $uuid = UUID::NIL;
        $invoice = $this->get(route('invoices.show', $uuid));

        $this->assertSame(Response::HTTP_NOT_FOUND, $invoice->getStatusCode());
    }
}
