<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'street',
        'city',
        'zip',
        'phone',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
