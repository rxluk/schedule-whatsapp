<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Client;
use App\Models\WorkingDays;
use App\Models\UnavailableDays;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        
        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $workingDays = $this->getWorkingDaysByUserId($request->user_id);
        $workingInDay = null;

        if(!$workingDays->isEmpty()) {
            $workingInDay = $workingDays->where('day_of_week', $this->getDayOfWeek($request->appointment_date))->first();
        }

        if(!$workingInDay) {
            return response()->json([
                'success' => false,
                'message' => 'O estabelecimento está fechado neste dia.'
            ], 200);
        }

        if($request->appointment_time < $workingInDay->opening_time || $request->appointment_time_end > $workingInDay->closing_time) {
            return response()->json([
                'success' => false,
                'message' => 'O horário selecionado está fora do horário de funcionamento do estabelecimento.'
            ], 200);
        }
        
        $unavailableDays = $this->getUnavailableDaysByUserId($request->user_id);
        $unavailableInDay = null;

        if(!$unavailableDays->isEmpty()) {
            $unavailableInDay = $unavailableDays->where('unavailable_date', $request->appointment_date)->first();
        }  

        if($unavailableInDay) {
            if($request->appointment_time >= $unavailableInDay->start_time && $request->appointment_time_end <= $unavailableInDay->end_time) {
                return response()->json([
                    'success' => false,
                    'message' => 'O estabelecimento está indisponível neste dia e horário: ' . $unavailableInDay->reason
                ], 200);
            }
        }

        if($request->appointment_time >= $request->appointment_time_end) {
            return response()->json([
                'success' => false,
                'message' => 'O horário de término deve ser maior que o horário de início.'
            ], 200);
        }

        try {
            $request->validate([
                'client_id' => 'required|exists:clients,id',
                'service_id' => 'required|exists:services,id',
                'user_id' => 'required|exists:users,id',
                'appointment_date' => 'required|date',
                'appointment_time' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'],
                'appointment_time_end' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'],
            ]);

            $appointmentData = [
                'client_id' => $request->client_id,
                'service_id' => $request->service_id,
                'user_id' => $request->user_id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'appointment_time_end' => $request->appointment_time_end,
                'status' => 'Agendado',
            ];

            $appointment = Appointment::create($appointmentData);

            return response()->json([
                'success' => true,
                'message' => 'Consulta agendada com sucesso',
                'data' => $appointment
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            
            throw $e;
            
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor ao criar agendamento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function getWorkingDaysByUserId($user_id)
    {
        $workingDays = WorkingDays::where('user_id', $user_id)
            ->get();

        return $workingDays;
    }

    private function getUnavailableDaysByUserId($user_id)
    {
        $unavailableDays = UnavailableDays::where('user_id', $user_id)
            ->get();

        return $unavailableDays;
    }

    private function getDayOfWeek($date)
    {
        $dayOfWeek = \Carbon\Carbon::parse($date)->dayOfWeekIso;
        return $dayOfWeek;
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
