<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::where('user_id', Auth::id())->get();
        
        return view('client.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
        ]);

        $client = Client::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente adicionado com sucesso',
            'data' => $client
        ], 201);
    }
}
