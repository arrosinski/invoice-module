<?php

declare(strict_types=1);

namespace Tests\Feature\App\Modules\Invoices\Infrastructure\Model;

use App\Modules\Invoices\Infrastructure\Model\Invoice;
use App\Modules\Invoices\Infrastructure\Model\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_total_price(): void
    {
        $invoice = Invoice::factory()
            ->hasAttached(
                Product::factory()
                    ->count(3)
                    ->state(new Sequence(
                        ['price' => 1],
                        ['price' => 10],
                        ['price' => 100],
                    )),
                //HACK: id should be generated automatically (in model or factory)
                fn ($sequence) => ['quantity' => 2, 'id' => Uuid::uuid4()]
            )
            ->create();

        $this->assertEquals(222, $invoice->totalPrice());
    }
}
