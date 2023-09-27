<?php

namespace Tests\Modules\Invoices\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testIndex()
    {
        $response = $this->get(route('invoices.index'));
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $index = $this->get(route('invoices.index'));
        $id = $index->json()['data'][0]['id'] ?? null;
        $this->assertNotNull($id);
        $response = $this->get(route('invoices.show', $id));
        $response->assertStatus(200);
    }
}
