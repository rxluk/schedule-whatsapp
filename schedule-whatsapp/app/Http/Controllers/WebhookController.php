<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receiveMessage(Request $request)
    {
        Log::info('Mensagem do WhatsApp recebida', ['payload' => $request->all()]);
        
        $event = $request->input('body.event');
        $remoteJid = $request->input('body.data.key.remoteJid');
        $pushName = $request->input('body.data.pushName');
        $message = $request->input('body.data.message.conversation');
        $sender = $request->input('body.sender');
        $dateTime = $request->input('body.date_time');
        
        if (empty($event) || empty($remoteJid) || empty($sender)) {
            return response()->json(['status' => 'error', 'message' => 'Dados incompletos'], 400);
        }
        
        $clientNumber = preg_replace('/@.*$/', '', $remoteJid);
        
        // Processar a mensagem (implementação completa será feita posteriormente)
        // TODO: Implementar a lógica de processamento da mensagem
        
        // Por enquanto, apenas retorna uma resposta de sucesso
        return response()->json(['status' => 'success', 'message' => 'Mensagem recebida']);
    }
}
