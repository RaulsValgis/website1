<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Http;

class SenderController extends Controller
{
    public function sendRequestToReceiver(Request $request)
    {
        $request->validate([
            'dataToSend' => 'required',
        ]);

        $dummyUser = new \stdClass;
        $dummyUser->id = 1;
        $token = JWTAuth::fromUser($dummyUser);

        $dataToSend = $request->input('dataToSend');

        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
            ->post('http://127.0.0.1:8001/api/receive-data', $dataToSend);

        return $response;
    }
}