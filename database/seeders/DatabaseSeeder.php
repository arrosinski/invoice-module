<?php

namespace Database\Seeders;

use App\Modules\Invoices\Infrastructure\Database\Seeders\DatabaseSeeder as InvoicesDatabaseSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            InvoicesDatabaseSeeder::class,
        ]);
    }
}
