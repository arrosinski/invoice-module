<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProductLine extends Model
{
    use HasFactory;
    use HasUuids;
}
