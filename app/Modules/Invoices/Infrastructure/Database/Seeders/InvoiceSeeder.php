<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Seeders;

use App\Modules\Invoices\Domain\ValueObjects\StatusEnum;
use Faker\Factory;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class InvoiceSeeder extends Seeder
{
    public function __construct(
        private ConnectionInterface $db
    ) {
    }

    public function run(): void
    {
        $companies = $this->db->table('companies')->get();
        $products = $this->db->table('products')->get();

        $invoices = [];

        for ($i = 0; $i < 10; $i++) {
            $invoices[] = self::stubInvoice($companies->random()->id);
        }

        $this->db->table('invoices')->insert($invoices);
        $this->addInvoiceProductLines($products, $invoices);
    }

    public static function stubInvoice($company_id): array
    {
        $faker = Factory::create();

        return [
            'id' => Uuid::uuid4()->toString(),
            'number' => $faker->uuid(),
            'date' => $faker->date(),
            'due_date' => $faker->date(),
            'company_id' => $company_id,
            'status' => StatusEnum::cases()[array_rand(StatusEnum::cases())],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function addInvoiceProductLines(Collection $products, array $invoices): void
    {

        $lines = [];

        foreach ($invoices ?? [] as $invoice) {
            $randomNumberOfProducts = rand(1, 5);
            $freshProducts = clone $products;

            for ($i = 0; $i < $randomNumberOfProducts; $i++) {
                $product = $freshProducts->pop();
                $lines[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'invoice_id' => $invoice['id'],
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'name' => $product->name,
                    'currency' => 'usd',
                    'quantity' => rand(1, 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $this->db->table('invoice_product_lines')->insert($lines);
    }
}
