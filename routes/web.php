<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoilCalculatorController;

Route::get('/', [SoilCalculatorController::class, 'index']);
Route::post('/calculate', [SoilCalculatorController::class, 'calculate'])->name('soil.calculate');
Route::get('/soil-types', [SoilCalculatorController::class, 'getSoilTypes'])->name('soil.types');
Route::post('/convert-units', [SoilCalculatorController::class, 'convertUnits'])->name('soil.convert');
