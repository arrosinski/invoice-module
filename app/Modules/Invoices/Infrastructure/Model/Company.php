<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Model;

use App\Modules\Invoices\Infrastructure\Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    use HasUuids;

    protected static function newFactory(): Factory
    {
        return CompanyFactory::new();
    }
}
