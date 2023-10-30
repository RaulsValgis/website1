<?php

use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\SenderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;





//Route::post('/send-data', [ReceiverController::class, 'processData'])->name('send-data');
//Route::post('/send-request', [SenderController::class, 'sendRequestToReceiver'])->name('send-request');
//Route::post('/receive-data', [ReceiverController::class, 'receiveData'])->name('receive-data');

Route::match(['get', 'post'], 'receive-data', [ReceiverController::class, 'receiveData']);
Route::match(['get', 'post'], 'send-data', [SenderController::class, 'sendData']);


// Route::get('/send-data', function () {
//     $data = [
//         "name"=> "John Doe",
//         "email"=> "john.doe@example.com",
//         "age"=> 30,
//         "user_id"=> 1,
//         "role"=> "guest"
//     ];

//     $response = Http::withHeaders(['Content-Type' => 'application/json'])->post('http://127.0.0.1:8001/api/receive-data', $data);
//     //dd($response);
//     //dd($data);
    
//     return $response->body();
// });

// Route::match(['get', 'post'], '/receive-data', function (Request $request) {
//     $receivedData = json_decode($request->getContent(), true);
//     //dd('r', $receivedData);

    
//     return response()->json(['message' => 'Data received successfully', 'receivedData' => $receivedData]);
// });