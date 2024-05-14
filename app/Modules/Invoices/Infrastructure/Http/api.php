<?php

declare(strict_types=1);

use App\Modules\Invoices\Infrastructure\Http\Controllers\InvoiceApprovalController;
use App\Modules\Invoices\Infrastructure\Http\Resources\InvoiceResource;
use App\Modules\Invoices\Infrastructure\Model\Invoice;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('api/invoices')
    ->group(function (): void {
        Route::get('{invoice}', function (Invoice $invoice) {
            return new InvoiceResource($invoice);
        });

        Route::patch('{invoice}/approval', InvoiceApprovalController::class);
    });
