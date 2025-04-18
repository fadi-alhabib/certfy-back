<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/', [CertificateController::class, 'generatePdf']);

Route::prefix('auth')->controller(BusinessController::class)->group(function () {
    Route::post('/register', 'store');
    Route::post('/login', 'login');
});

Route::prefix('certificates')->controller(CertificateController::class)->group(function () {
    Route::get('/', 'index')->middleware('auth:sanctum');
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::get('/{id}', 'show')->middleware('auth:sanctum');
    Route::post('/{id}/certfy', 'certfy');
});

Route::prefix('customers')->controller(CustomerController::class)->group(function () {
    Route::get('/', 'index')->middleware('auth:sanctum');
});
