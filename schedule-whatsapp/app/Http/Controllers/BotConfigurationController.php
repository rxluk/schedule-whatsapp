<?php

namespace App\Http\Controllers;

use App\Bot\Menu\MenuFactory;
use App\Models\BotConfiguration;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BotConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();
        $professional = $user->professional;
        
        if (!$professional) {
            return redirect()->route('dashboard')
                             ->with('error', 'Perfil profissional não encontrado.');
        }
        
        $botConfig = $professional->botConfiguration ?? new BotConfiguration();
        
        return view('bot.configuration.index', compact('professional', 'botConfig'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->route('bot.configuration.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $professional = $user->professional;
        
        if (!$professional) {
            return redirect()->back()
                             ->with('error', 'Perfil profissional não encontrado.');
        }
        
        // Validar dados
        $validator = Validator::make($request->all(), [
            'welcome_message' => 'required|string|min:10',
            'appointment_success_message' => 'required|string|min:10',
            'appointment_canceled_message' => 'required|string|min:10',
            'no_available_times_message' => 'required|string|min:10',
            'payment_info_text' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
        
        $botConfig = $professional->botConfiguration ?? new BotConfiguration();
        $botConfig->professional_id = $professional->professional_id;
        $botConfig->welcome_message = $request->welcome_message;
        $botConfig->appointment_success_message = $request->appointment_success_message;
        $botConfig->appointment_canceled_message = $request->appointment_canceled_message;
        $botConfig->no_available_times_message = $request->no_available_times_message;
        $botConfig->payment_info_text = $request->payment_info_text;
        
        if (empty($botConfig->bot_menu_structure_json)) {
            $defaultMenu = MenuFactory::createDefaultMenu();
            $botConfig->bot_menu_structure_json = $defaultMenu->toArray();
        }
        
        $botConfig->save();
        
        return redirect()->route('bot.configuration.index')
                         ->with('success', 'Configurações do bot salvas com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return redirect()->route('bot.configuration.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $user = Auth::user();
        $professional = $user->professional;
        
        if (!$professional || $professional->professional_id != $id) {
            return redirect()->route('dashboard')
                             ->with('error', 'Você não tem permissão para editar esta configuração.');
        }
        
        $botConfig = $professional->botConfiguration;
        
        if (!$botConfig) {
            return redirect()->route('bot.configuration.index')
                             ->with('info', 'Configure seu bot primeiro.');
        }
        
        return view('bot.configuration.edit', compact('professional', 'botConfig'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $professional = $user->professional;
        
        if (!$professional || $professional->professional_id != $id) {
            return redirect()->route('dashboard')
                             ->with('error', 'Você não tem permissão para editar esta configuração.');
        }
        
        $validator = Validator::make($request->all(), [
            'welcome_message' => 'required|string|min:10',
            'appointment_success_message' => 'required|string|min:10',
            'appointment_canceled_message' => 'required|string|min:10',
            'no_available_times_message' => 'required|string|min:10',
            'payment_info_text' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
        
        $botConfig = BotConfiguration::where('professional_id', $professional->professional_id)->first();
        
        if (!$botConfig) {
            return redirect()->route('bot.configuration.index')
                             ->with('error', 'Configuração não encontrada.');
        }
        
        $botConfig->welcome_message = $request->welcome_message;
        $botConfig->appointment_success_message = $request->appointment_success_message;
        $botConfig->appointment_canceled_message = $request->appointment_canceled_message;
        $botConfig->no_available_times_message = $request->no_available_times_message;
        $botConfig->payment_info_text = $request->payment_info_text;
        $botConfig->save();
        
        return redirect()->route('bot.configuration.index')
                         ->with('success', 'Configurações do bot atualizadas com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $professional = $user->professional;
        
        if (!$professional || $professional->professional_id != $id) {
            return redirect()->route('dashboard')
                             ->with('error', 'Você não tem permissão para excluir esta configuração.');
        }
        
        $botConfig = BotConfiguration::where('professional_id', $professional->professional_id)->first();
        
        if ($botConfig) {
            $botConfig->delete();
            return redirect()->route('bot.configuration.index')
                             ->with('success', 'Configurações do bot excluídas com sucesso!');
        }
        
        return redirect()->route('bot.configuration.index')
                         ->with('info', 'Configuração não encontrada.');
    }
}
