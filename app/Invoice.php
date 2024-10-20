<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'number',
        'date',
        'due_date',
        'company_id',
        'billed_company_id',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function billedCompany()
    {
        return $this->belongsTo(Company::class, 'billed_company_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'invoice_product_lines')
            ->withPivot('quantity');
    }
}
