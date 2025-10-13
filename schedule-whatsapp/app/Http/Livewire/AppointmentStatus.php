<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentStatus extends Component
{
    public $appointment;
    public $appointmentId;
    public $status;
    public $statusOptions = [
        'Agendado',
        'Realizado',
        'Cancelado',
        'Não Compareceu'
    ];

    protected $listeners = ['updateStatus'];

    public $canEdit = false;
    
    public function mount($appointment)
    {
        $this->appointment = $appointment;
        $this->appointmentId = $appointment->id;
        $this->status = $appointment->status;
        
        $this->canEdit = ($appointment->user_id === Auth::id());
    }

    public function updateStatus($status)
    {
        $this->validate([
            'status' => 'required|string|in:Agendado,Realizado,Cancelado,Não Compareceu',
        ]);

        $appointment = Appointment::find($this->appointmentId);
        
        if (!$appointment) {
            session()->flash('error', 'Agendamento não encontrado.');
            return;
        }
        
        if ($appointment->user_id !== Auth::id()) {
            session()->flash('error', 'Você não tem permissão para alterar este agendamento.');
            return;
        }

        $appointment->status = $status;
        $appointment->save();

        $this->status = $status;
        
        // session()->flash('message', 'Status do agendamento atualizado com sucesso!');
        
        $this->emit('statusUpdated');
    }

    public function changeStatus($newStatus)
    {
        $appointment = Appointment::find($this->appointmentId);
        
        if (!$appointment) {
            session()->flash('error', 'Agendamento não encontrado.');
            return;
        }
        
        if ($appointment->user_id !== Auth::id()) {
            session()->flash('error', 'Você não tem permissão para alterar este agendamento.');
            return;
        }
        
        $this->updateStatus($newStatus);
    }

    public function render()
    {
        return view('livewire.appointment-status');
    }
}