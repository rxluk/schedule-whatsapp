@extends('layouts.layout')

@section('title', 'Agenda - AgendaZap')

@section('content')
    <div class="appointments-container">
        <div class="appointments-header">
            <h1 class="page-title">Minha Agenda</h1>
            <div class="appointment-actions">
                <a href="#" class="btn-add-appointment">
                    <i class="fas fa-plus"></i> Novo Agendamento
                </a>
            </div>
        </div>
        
        <div class="appointments-content">
            @if($appointments->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="far fa-calendar"></i>
                    </div>
                    <h3>Sem agendamentos</h3>
                    <p>Você ainda não possui nenhum agendamento cadastrado.</p>
                </div>
            @else
                <div class="appointments-list">
                    @foreach($appointments as $appointment)
                        <div class="appointment-card">
                            <div class="appointment-date-header">
                                <div class="date-text">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d') }} - {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M') }}</div>
                            </div>
                            <div class="appointment-content">
                                <div class="appointment-time">
                                    <i class="far fa-clock"></i> {{ $appointment->appointment_time }}
                                </div>
                                <div class="appointment-top">
                                    <div class="appointment-client">
                                        <h4>{{ $appointment->client->name ?? 'Cliente' }}</h4>
                                        <p class="service-name">{{ $appointment->service->name ?? 'Serviço' }}</p>
                                    </div>
                                    <div class="appointment-status-wrapper">
                                        @livewire('appointment-status', ['appointment' => $appointment], key('appointment-'.$appointment->id))
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@section('styles')
<style>
    .appointments-container {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .appointments-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .page-title {
        font-size: 24px;
        color: var(--dark-color);
        margin: 0;
    }
    
    .btn-add-appointment {
        background-color: var(--accent-color);
        color: var(--white);
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
    }
    
    .btn-add-appointment:hover {
        background-color: #2b98c7;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background-color: var(--white);
        border-radius: 12px;
        box-shadow: var(--box-shadow);
    }
    
    .empty-icon {
        font-size: 60px;
        color: var(--accent-color);
        margin-bottom: 20px;
        opacity: 0.7;
    }
    
    .empty-state h3 {
        color: var(--dark-color);
        margin-bottom: 10px;
    }
    
    .empty-state p {
        color: var(--text-color);
        max-width: 300px;
        margin: 0 auto;
    }
    
    .appointments-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .appointment-card {
        position: relative;
        background-color: var(--white);
        padding: 0;
        border-radius: 12px;
        box-shadow: var(--box-shadow);
        display: flex;
        flex-direction: column;
    }
    
    .appointment-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    
    .appointment-date-header {
        width: 100%;
        background-color: var(--accent-color);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        border-radius: 12px 12px 0 0;
        padding: 10px;
    }
    
    .date-text {
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .appointment-content {
        padding: 12px;
    }
    
    .appointment-time {
        font-weight: 500;
        color: var(--dark-color);
        font-size: 14px;
        margin-bottom: 8px;
    }
    
    .appointment-content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .appointment-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 5px;
    }
    
    .appointment-client {
        flex: 1;
    }
    
    .appointment-status-wrapper {
        position: relative;
        z-index: 5;
        margin-left: 10px;
    }
    
    .appointment-client h4 {
        font-size: 15px;
        color: var(--dark-color);
        margin: 0 0 3px;
    }
    
    .service-name {
        font-size: 13px;
        color: var(--text-color);
        margin: 0;
    }
    
    .appointment-status {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
        width: 90px;
        text-align: center;
        display: inline-block;
    }
    
    .appointment-status[data-status="agendado"] {
        background-color: #e5f7ff;
        color: #0094cc;
    }
    
    .appointment-status[data-status="concluído"] {
        background-color: #e5fff2;
        color: #00cc77;
    }
    
    .appointment-status[data-status="cancelado"] {
        background-color: #fff2f2;
        color: #ff4c4c;
    }
    
    /* Responsividade para mobile */
    @media (max-width: 768px) {
        .appointments-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
    }
    
    @media (max-width: 576px) {
        .appointment-top {
            flex-wrap: nowrap;
            align-items: center;
        }
        
        .appointment-client {
            max-width: 65%;
        }
        
        .appointment-status-wrapper {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }
        
        .date-text {
            font-size: 14px;
        }
    }
</style>
@endsection