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
                            <div class="appointment-date">
                                <div class="date-day">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d') }}</div>
                                <div class="date-month">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M') }}</div>
                            </div>
                            <div class="appointment-details">
                                <div class="appointment-time">
                                    <i class="far fa-clock"></i> {{ $appointment->appointment_time }}
                                </div>
                                <div class="appointment-client">
                                    <h4>{{ $appointment->client->name ?? 'Cliente' }}</h4>
                                    <p class="service-name">{{ $appointment->service->name ?? 'Serviço' }}</p>
                                </div>
                                <div class="appointment-status-wrapper">
                                    @livewire('appointment-status', ['appointment' => $appointment], key('appointment-'.$appointment->id))
                                </div>
                            </div>
                            <div class="appointment-actions">
                                <a href="#" class="btn-icon" title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="#" class="btn-icon" title="Cancelar">
                                    <i class="fas fa-times"></i>
                                </a>
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
        transform: translateY(-2px);
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
        gap: 15px;
        overflow: visible;
    }
    
    .appointment-card {
        display: flex;
        align-items: center;
        background-color: var(--white);
        border-radius: 12px;
        box-shadow: var(--box-shadow);
        overflow: visible;
        transition: all 0.3s;
    }
    
    .appointment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .appointment-date {
        width: 80px;
        height: 80px;
        background-color: var(--accent-color);
        color: var(--white);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    .date-day {
        font-size: 24px;
        line-height: 1;
    }
    
    .date-month {
        font-size: 14px;
        text-transform: uppercase;
    }
    
    .appointment-details {
        flex: 1;
        padding: 15px;
        display: flex;
        align-items: center;
    }
    
    .appointment-time {
        width: 100px;
        font-weight: 500;
        color: var(--dark-color);
    }
    
    .appointment-client {
        flex: 1;
    }
    
    .appointment-status-wrapper {
        position: relative;
        z-index: 900;
        width: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }
    
    .appointment-client h4 {
        font-size: 16px;
        color: var(--dark-color);
        margin: 0 0 5px;
    }
    
    .service-name {
        font-size: 14px;
        color: var(--text-color);
        margin: 0;
    }
    
    .appointment-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        width: 100px;
        text-align: center;
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
    
    .appointment-actions {
        padding: 15px;
        display: flex;
        gap: 8px;
    }
    
    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background-color: var(--light-color);
        color: var(--text-color);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-icon:hover {
        background-color: var(--accent-color);
        color: var(--white);
    }
    
    /* Responsividade para mobile */
    @media (max-width: 768px) {
        .appointments-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .appointment-details {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .appointment-time, .appointment-client, .appointment-status {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .appointment-time {
            margin-bottom: 5px;
        }
    }
    
    @media (max-width: 576px) {
        .appointment-card {
            flex-direction: column;
            align-items: stretch;
        }
        
        .appointment-date {
            width: 100%;
            height: auto;
            padding: 10px;
            flex-direction: row;
            justify-content: center;
            gap: 10px;
        }
    }
</style>
@endsection