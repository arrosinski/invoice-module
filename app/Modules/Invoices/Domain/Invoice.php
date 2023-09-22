<?php

namespace App\Modules\Invoices\Domain;

use App\Domain\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $keyType = 'string';

    public Uuid $id;
    public string $number;
    public string $date;
    public string $dueDate;
    public StatusEnum $status;

    public string $createdAt;
    public string $updatedAt;

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function lineItems()
    {
        return $this->hasMany(LineItem::class, 'invoice_id', 'id');
    }

}

