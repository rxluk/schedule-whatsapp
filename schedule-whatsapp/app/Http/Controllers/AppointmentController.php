<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->with(['client', 'service'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();
            
        return view('appointments.index', compact('appointments'));
    }

    public function getAppointmentsByUserId(Request $request)
    {
        $appointments = Appointment::where('user_id', $request->user_id)
            ->get();
        
        if($appointments->isEmpty()) {
            return response()->json(['error' => 'No appointments found for this user'], 404);
        }
        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'required|exists:services,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
        ]);

        $appointment = Appointment::create([
            'client_id' => $request->client_id,
            'service_id' => $request->service_id,
            'user_id' => $request->user_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'Agendado',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Consulta agendada com sucesso',
            'data' => $appointment
        ], 201);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
