<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Factories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Infrastructure\Model\Company;
use App\Modules\Invoices\Infrastructure\Model\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
final class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'number' => $this->faker->uuid(),
            'date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'company_id' => Company::factory(),
            'status' => StatusEnum::DRAFT,
        ];
    }
}
