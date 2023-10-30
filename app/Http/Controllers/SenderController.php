<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;

class SenderController extends Controller
{
    public function sendRequestToReceiver(Request $request)
    {
        $request->validate([
            'dataToSend' => 'required',
        ]);

        // Retrieve the shared secret key from your configuration
        $sharedSecretKey = config('jwt.shared_secret_key');

        $dataToSend = $request->input('dataToSend');

        // Generate a JWT token using the shared secret key
        $token = JWT::encode(['data' => $dataToSend], $sharedSecretKey, 'HS256');

        // Call the sendData method to send the data
        $response = $this->sendData();

        return $response;
    }

    public function sendData()
    {
        // Your existing code here
        $data = [
            "name" => "John Doe",
            "email" => "john.doe@example.com",
            "age" => 30,
            "user_id" => 1,
            "role" => "guest"
        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])->post('http://127.0.0.1:8001/api/receive-data', $data);

        return $response->body();
    }
}