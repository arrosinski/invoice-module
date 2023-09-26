<?php

namespace App\Modules\Invoices\Infrastructure\Database\Dao;

use Illuminate\Database\Eloquent\Model;

class LineItemDao extends Model
{
    protected $table = 'invoice_product_lines';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
}
