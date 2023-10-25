<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use JWTAuth;
use \Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Http;

class SenderController extends Controller
{
    








    public function sendRequestToReceiver(Request $request)
    {
        $token = $request->input('token'); // Assuming 'token' is the key for the token in your request
        $dataToSend = $request->input('dataToSend'); // Assuming 'dataToSend' is the key for the dataToSend in your request

        // Your existing code for sending the request
        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
            ->post('http://127.0.0.1:8001/api/resource', $dataToSend);

        // Process the response as needed
        return $response;
    }









}
