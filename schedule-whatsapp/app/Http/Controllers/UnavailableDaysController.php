<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UnavailableDays;

class UnavailableDaysController extends Controller
{
    public function index()
    {
        $unavailableDays = UnavailableDays::where('user_id', Auth::id())
            ->orderBy('unavailable_date', 'desc')
            ->get();

        return view('unavailable_days.index', compact('unavailableDays'));
    }

    public function create()
    {
        return view('unavailable_days.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'unavailable_date' => 'required|date',
                'start_time' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
                'end_time' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
                'reason' => 'nullable|string|max:255',
            ]);

            $unavailableDayData = [
                'user_id' => Auth::id(),
                'unavailable_date' => $request->unavailable_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'reason' => $request->reason,
            ];

            $unavailableDay = UnavailableDays::create($unavailableDayData);

            return redirect()->route('unavailable-days.index')
                ->with('success', 'Dia indisponível criado com sucesso!');
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro interno do servidor ao criar dia indisponível: ' . $e->getMessage())
                ->withInput();
        }
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
