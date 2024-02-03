<?php

use App\Modules\Invoices\Application\Controllers\ApprovalController;
use App\Modules\Invoices\Application\Controllers\InvoicesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    '/invoices/{uuid}',
    [InvoicesController::class, 'showAction']
)->name('invoices.show');

// Could be a PUT request, as it is considered idempotent
Route::post(
    '/invoices/{uuid}/approve',
    [ApprovalController::class, 'approveAction']
)->name('invoices.approve');

Route::post(
    '/invoices/{uuid}/reject',
    [ApprovalController::class, 'rejectAction']
)->name('invoices.reject');
