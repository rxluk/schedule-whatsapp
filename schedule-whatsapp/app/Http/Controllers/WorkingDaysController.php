<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkingDays;
use Illuminate\Support\Facades\Auth;

class WorkingDaysController extends Controller
{
    public function index()
    {
        $workingDays = WorkingDays::where('user_id', Auth::id())
            ->orderBy('day_of_week', 'asc')
            ->get();

        return view('working_days.index', compact('workingDays'));
    }

    public function create()
    {
        return view('working_days.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'day_of_week' => 'required|in:1,2,3,4,5,6,7',
                'opening_time' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
                'closing_time' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
            ]);

            $workingDayData = [
                'user_id' => Auth::id(),
                'day_of_week' => $request->day_of_week,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
            ];

            $workingDay = WorkingDays::create($workingDayData);

            return redirect()->route('working-days.index')
                ->with('success', 'Dia útil criado com sucesso!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro interno do servidor ao criar dia útil: ' . $e->getMessage())
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
