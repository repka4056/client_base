<?php

use App\Http\Controllers\ClientController;

Route::get('/', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clients/create', function () {
    return view('clients.create');
})->name('clients.create');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/clients/export', [ClientController::class, 'export'])->name('clients.export');
Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
Route::get('/', [ClientController::class, 'index'])->name('clients.index');
