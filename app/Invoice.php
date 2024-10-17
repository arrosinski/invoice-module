<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id',
        'number',
        'date',
        'due_date',
        'company_id',
        'status',
    ];

    protected $keyType = 'string';
}
