<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReceiverController extends Controller
{
    public function processData(Request $request)
    {
        // Authenticate and retrieve the data from the JWT
        $data = JWTAuth::parseToken()->authenticate();

        if (!$data) {
            // Handle authentication failure
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Example: Access data from the JWT
        $userId = $data['user_id'];
        $userRole = $data['role'];

        // Process the data as needed
        // For example, you can perform actions based on the user's role
        if ($userRole === 'admin') {
            // Perform admin-specific actions
        } else {
            // Perform actions for other roles or guests
        }

        // You can also access other data from the request, if needed
        $requestData = $request->all();

        // Return a response
        return response()->json(['message' => 'Data processed successfully']);
    }
}
