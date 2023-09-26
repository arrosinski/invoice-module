<?php

namespace App\Modules\Invoices\Infrastructure\Database\Dao;

use Illuminate\Database\Eloquent\Model;

class CompanyDao extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
}
