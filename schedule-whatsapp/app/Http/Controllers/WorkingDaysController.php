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

    public function getWorkingDaysByUserId(Request $request)
    {
        $workingDays = WorkingDays::where('user_id', $request->user_id)
            ->select('day_of_week', 'opening_time', 'closing_time')
            ->orderBy('day_of_week', 'asc')
            ->get();
        return response()->json($workingDays);
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
        $workingDay = WorkingDays::findOrFail($id);
        
        if ($workingDay->user_id != Auth::id()) {
            return redirect()->route('working-days.index')
                ->with('error', 'Você não tem permissão para editar este dia útil.');
        }
        
        return view('working_days.edit', compact('workingDay'));
    }

    public function update(Request $request, $id)
    {
        try {
            $workingDay = WorkingDays::findOrFail($id);
            
            if ($workingDay->user_id != Auth::id()) {
                return redirect()->route('working-days.index')
                    ->with('error', 'Você não tem permissão para atualizar este dia útil.');
            }
            
            $request->validate([
                'day_of_week' => 'required|in:1,2,3,4,5,6,7',
                'opening_time' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
                'closing_time' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
            ]);
            
            $workingDay->update([
                'day_of_week' => $request->day_of_week,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
            ]);
            
            return redirect()->route('working-days.index')
                ->with('success', 'Dia útil atualizado com sucesso!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro interno do servidor ao atualizar dia útil: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $workingDay = WorkingDays::findOrFail($id);
            
            if ($workingDay->user_id != Auth::id()) {
                return redirect()->route('working-days.index')
                    ->with('error', 'Você não tem permissão para excluir este dia útil.');
            }
            
            $workingDay->delete();
            
            return redirect()->route('working-days.index')
                ->with('success', 'Dia útil excluído com sucesso.');
                
        } catch (\Exception $e) {
            return redirect()->route('working-days.index')
                ->with('error', 'Ocorreu um erro ao excluir o dia útil: ' . $e->getMessage());
        }
    }
}
