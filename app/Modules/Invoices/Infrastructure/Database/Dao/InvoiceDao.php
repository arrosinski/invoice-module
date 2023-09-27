<?php

namespace App\Modules\Invoices\Infrastructure\Database\Dao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceDao extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public function company(): HasOne
    {
        return $this->hasOne(CompanyDao::class, 'id', 'company_id');
    }
    public function lineItems(): HasMany
    {
        return $this->hasMany(LineItemDao::class, 'invoice_id', 'id');
    }

}
