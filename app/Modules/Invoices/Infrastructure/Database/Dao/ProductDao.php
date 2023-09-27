<?php

namespace App\Modules\Invoices\Infrastructure\Database\Dao;
use Illuminate\Database\Eloquent\Model;

class ProductDao extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

}
