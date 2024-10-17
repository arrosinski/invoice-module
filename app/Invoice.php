<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'number',
        'date',
        'due_date',
        'company_id',
        'billed_company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function billedCompany()
    {
        return $this->belongsTo(Company::class, 'billed_company_id');
    }
}
