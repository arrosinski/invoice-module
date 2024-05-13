<?php

declare(strict_types=1);

namespace Tests\Feature\App\Modules\Invoices\Infrastructure\Http\Resources;

use App\Modules\Invoices\Infrastructure\Database\Seeders\DatabaseSeeder;
use App\Modules\Invoices\Infrastructure\Model\Invoice;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class InvoiceResourceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get(): void
    {
        $this->seed(DatabaseSeeder::class);
        $invoice = Invoice::first();

        $response = $this->get('api/invoices/' . $invoice->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['invoice_number' => $invoice->number]);
        $response->assertJsonStructure([
            'data' => [
                'invoice_number',
                'invoice_date',
                'due_date',
                'company' => [
                    'name',
                    'street_address',
                    'city',
                    'zip_code',
                    'phone',
                ],
                'billed_company' => [
                    'name',
                    'street_address',
                    'city',
                    'zip_code',
                    'phone',
                    'email_address',
                ],
                'products' => [
                    '*' => [
                        'name',
                        'quantity',
                        'unit_price',
                        'total',
                    ],
                ],
                'total_price',
            ],
        ]);
    }
}
