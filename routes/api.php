<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\InvoiceItemController;
use App\Http\Controllers\API\BankAccountController;
use App\Http\Controllers\API\DeveloperController;
use App\Http\Controllers\TransactionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
#invoice routes
Route::middleware('auth:sanctum')->group(function () {
    // Route::apiResource('invoices', InvoiceController::class);
    // Route::apiResource('invoices.items', InvoiceItemController::class);
});
## Invoices
Route::apiResource('invoices', InvoiceController::class);
Route::apiResource('invoices.items', InvoiceItemController::class);

## Transactions
Route::get('transactions', [TransactionsController::class, 'index']);
Route::post('transactions', [TransactionsController::class, 'store']);
Route::get('transactions/{id}', [TransactionsController::class, 'show']);
Route::put('transactions/{id}', [TransactionsController::class, 'update']);
Route::delete('transactions/{id}', [TransactionsController::class, 'destroy']);

## Developers
Route::get('developers', [DeveloperController::class, 'index']);
Route::post('developers', [DeveloperController::class, 'store']);
Route::get('developers/{id}', [DeveloperController::class, 'show']);
Route::put('developers/{id}', [DeveloperController::class, 'update']);
Route::delete('developers/{id}', [DeveloperController::class, 'destroy']);

## Bank Accounts
Route::get('bank_accounts', [BankAccountController::class, 'index']);
Route::post('bank_accounts', [BankAccountController::class, 'store']);
Route::get('bank_accounts/{id}', [BankAccountController::class, 'show']);
Route::put('bank_accounts/{id}', [BankAccountController::class, 'update']);
Route::delete('bank_accounts/{id}', [BankAccountController::class, 'destroy']);

## Call Logs
Route::get('all-user-calls', 'call_logs_users');
Route::post('upsert', 'upsert');
Route::get('/userLogs/{id}', 'userLogs');
Route::get('callLogs', 'callLogs');
