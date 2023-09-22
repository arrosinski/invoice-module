<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Invoices\Api\InvoiceController;
use App\Modules\Approval\Api\ApprovalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get(
    '/invoices', [InvoiceController::class, 'index']
);

Route::get(
    '/invoices/{id}', [InvoiceController::class, 'show']);

Route::post(
    '/invoices/{id}/approve', [ApprovalController::class, 'approve']
);

Route::post(
    '/invoices/{id}/reject', [ApprovalController::class, 'reject']
);
