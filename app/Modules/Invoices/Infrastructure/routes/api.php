<?php

declare(strict_types=1);

use App\Modules\Invoices\Infrastructure\Http\Resources\InvoiceResource;
use App\Modules\Invoices\Infrastructure\Model\Invoice;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('api/invoices')
    ->group(function (): void {
        Route::get('{id}', function (string $id) {
            return new InvoiceResource(Invoice::findOrFail($id));
        });
    });
