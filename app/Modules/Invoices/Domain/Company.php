<?php

namespace App\Modules\Invoices\Domain;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Company extends Model
{
    protected $table = 'companies';
    protected $keyType = 'string';
    private Uuid $id;
    private string $name;
    private string $address;
    private string $taxNumber;
    private string $createdAt;
    private string $updatedAt;
}
