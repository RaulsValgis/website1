<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use stdClass;

class ReceiverController extends Controller
{
    public function processData(Request $request)
    {
        $requestData = $request->json()->all();
        return response()->json(['message' => 'Data processed successfully', 'data' => $requestData]);
    }

    public function receiveData(Request $request)
    {
        $sharedSecretKey = config('jwt.shared_secret_key');

        $apiToken = $request->bearerToken();

        if (!$apiToken) {
            return response('Unauthorized', 401);
        }

        // Define the allowed algorithms (HS256 in this case)
        $allowedAlgorithms = new stdClass();
        $allowedAlgorithms->alg = 'HS256';

        try {
            // Decode the JWT token using the shared secret key and allowed algorithms
            $decoded = JWT::decode($apiToken, $sharedSecretKey, $allowedAlgorithms);
        } catch (\Exception $e) {
            return response('Unauthorized', 401);
        }

        // Now you can access the decoded data from the token
        $receivedData = json_decode($request->getContent(), true);

        return response()->json(['message' => 'Data received successfully', 'receivedData' => $receivedData]);
    }
}