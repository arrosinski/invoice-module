<?php

declare(strict_types=1);

namespace Tests\Feature\App\Modules\Invoices\Infrastructure\Http\Controllers;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Infrastructure\Model\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

final class InvoiceApprovalControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_approve(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->patchJson('api/invoices/' . $invoice->id . '/approval', [
            'status' => StatusEnum::APPROVED->value,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => StatusEnum::APPROVED,
        ]);
    }

    public function test_reject(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->patchJson('api/invoices/' . $invoice->id . '/approval', [
            'status' => StatusEnum::REJECTED->value,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => StatusEnum::REJECTED,
        ]);
    }

    public function test_wrong_status(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->patchJson('api/invoices/' . $invoice->id . '/approval', [
            'status' => 'test',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_invoice_in_wrong_state(): void
    {
        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::APPROVED,
        ]);

        $response = $this->patchJson('api/invoices/' . $invoice->id . '/approval', [
            'status' => StatusEnum::REJECTED->value,
        ]);

        $response->assertStatus(Response::HTTP_CONFLICT);
    }
}
