<?php

namespace App\Modules\Invoices\Infrastructure\Database\Dao;

use Illuminate\Database\Eloquent\Model;

class InvoiceDao extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';

    protected $keyType = 'string';
}
