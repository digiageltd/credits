<?php

use App\Http\Controllers\CreditsController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CreditsController::class, 'index'])->name('credits.index');

Route::prefix('credits')->as('credits.')->group(function () {
    Route::get('create', [CreditsController::class, 'create'])->name('create');
    Route::post('store', [CreditsController::class, 'store'])->name('store');
    Route::get('/{credit}', [CreditsController::class, 'show'])->name('show');
    Route::get('/maximum-reached', [CreditsController::class, ''])->name('maximum-reached');
});

Route::prefix('payment')->as('payment.')->group(function () {
    Route::get('/pay/{credit?}', [PaymentController::class, 'index'])->name('index');
    Route::post('/credit', [PaymentController::class, 'makePayment'])->name('make');
    Route::get('/installment/{installment}', [PaymentController::class, 'makeInstallmentPayment'])->name('make-installment-payment');
});
