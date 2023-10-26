<?php

use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\SenderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



Route::middleware(['api'])->group(function () {
    Route::post('/send-data', [ReceiverController::class, 'processData'])->name('send-data');
    Route::post('/send-request', [SenderController::class, 'sendRequestToReceiver'])->name('send-request');
    Route::post('/receive-data', [ReceiverController::class, 'receiveData'])->name('receive-data');
});


Route::get('/send-data', function () {
    $data = [
        "name"=> "John Doe",
        "email"=> "john.doe@example.com",
        "age"=> 30,
        "user_id"=> 1,
        "role"=> "guest"
    ];

    $response = Http::post('http://127.0.0.1:8001/api/receive-data', $data);

    return $response->body();
});

Route::post('/receive-data', function (Request $request) {
    $receivedData = $request->all();
    dd('r', $receivedData);

    
    return response()->json(['message' => 'Data received successfully', 'receivedData' => $receivedData]);
});