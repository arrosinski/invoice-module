<?php

namespace App\Modules\Invoices\Infrastructure\Database\Factories;

use App\Modules\Invoices\Domain\ValueObjects\StatusEnum;
use App\Modules\Invoices\Infrastructure\Database\Dao\InvoiceDao;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = InvoiceDao::class;
    public function definition(): array
    {
        return [
                'id' => Uuid::uuid4()->toString(),
                'number' => fake()->uuid(),
                'date' => fake()->date(),
                'due_date' => fake()->date(),
                'status' => StatusEnum::cases()[array_rand(StatusEnum::cases())],
                'created_at' => now(),
                'updated_at' => now(),
        ];
    }
}
