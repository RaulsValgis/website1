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
        $receivedData = $request->all();
        \Log::info('Received data:', ['receivedData' => $receivedData]);
        dd($receivedData);
        

        return response()->json(['message' => 'Data received successfully', 'receivedData' => $receivedData]);
    }

}
