<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;

class UtilsController extends Controller
{
    public function getUserAndClientIdsByPhone(Request $request)
    {
        $userId = User::where('phone_number', $request->user_phone)->value('id');
        $clientId = Client::where('phone_number', $request->client_phone)->value('id');
        
        return response()->json([
            'user_id' => $userId,
            'client_id' => $clientId,
        ]);
    }
}
