<?php

use App\Http\Controllers\ReceiverController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->post('/resource', [ReceiverController::class, 'processData'])->name('processdata');

