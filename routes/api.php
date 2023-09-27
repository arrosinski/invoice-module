<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Invoices\Api\InvoiceController;
use App\Modules\Approval\Api\InvoiceApprovalController;

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
)->name('invoices.index');

Route::get(
    '/invoices/{id}', [InvoiceController::class, 'show']
)->name('invoices.show');

// Could be a PUT request, as it is considered idempotent
Route::post(
    '/invoices/{id}/approve', [InvoiceApprovalController::class, 'approve']
)->name('invoices.approve');

Route::post(
    '/invoices/{id}/reject', [InvoiceApprovalController::class, 'reject']
)->name('invoices.reject');
