<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReceiverController extends Controller
{
    public function processData(Request $request)
    {
        $requestData = $request->json()->all();
        return response()->json(['message' => 'Data processed successfully', 'data' => $requestData]);
    }

    public function receiveData(Request $request)
    {
        $receivedData = $request->json()->all();
        // \Log::info('Received data:', ['receivedData' => $receivedData]);
        if ($receivedData !== null) {
            // Data processing logic
            return response()->json(['message' => 'Data received successfully', 'receivedData' => $receivedData]);
        } else {
            // Handle the case where the data is null
            return response()->json(['message' => 'No data received']);
        }
    }
}