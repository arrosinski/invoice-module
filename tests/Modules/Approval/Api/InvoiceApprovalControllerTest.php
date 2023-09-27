<?php

namespace Tests\Modules\Approval\Api;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceApprovalControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testApprove(): void {
        $index = $this->get(route('invoices.index'));
        $id = current(array_filter($index->json()['data'], fn($invoice) => $invoice['status'] === 'draft'))['id'];
        $this->assertNotNull($id);
        $response = $this->post(route('invoices.approve', $id));
        $response->assertStatus(200);
    }


    public function testReject(): void {
        $index = $this->get(route('invoices.index'));
        $id = current(array_filter($index->json()['data'], fn($invoice) => $invoice['status'] === 'draft'))['id'];
        $this->assertNotNull($id);
        $response = $this->post(route('invoices.reject', $id));
        $response->assertStatus(200);
    }


    public function testCantApprove(): void {
        $index = $this->get(route('invoices.index'));
        $id = current(array_filter($index->json()['data'], fn($invoice) => $invoice['status'] !== 'draft'))['id'];
        $this->assertNotNull($id);
        $response = $this->post(route('invoices.approve', $id));
        $response->assertStatus(400);
    }


    public function testCantReject(): void {
        $index = $this->get(route('invoices.index'));
        $id = current(array_filter($index->json()['data'], fn($invoice) => $invoice['status'] !== 'draft'))['id'];
        $this->assertNotNull($id);
        $response = $this->post(route('invoices.reject', $id));
        $response->assertStatus(400);
    }
}
