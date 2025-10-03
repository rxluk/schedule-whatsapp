@extends('layouts.layout')

@section('title', 'Dashboard - AgendaZap')

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Bem-vindo(a), {{ Auth::user()->name }}</h1>
            <p class="dashboard-subtitle">Gerencie seus agendamentos facilmente</p>
        </div>
        
        <div class="dashboard-cards">
            <!-- Card de acesso rápido à agenda -->
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Agenda</h3>
                    <p class="card-description">Visualize e gerencie seus compromissos</p>
                </div>
                <a href="{{ route('appointments.index') }}" class="card-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <!-- Aqui podem ser adicionados mais cards no futuro -->
        </div>
    </div>
@endsection

@section('styles')
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .dashboard-header {
        margin-bottom: 30px;
    }
    
    .dashboard-title {
        font-size: 24px;
        color: var(--dark-color);
        margin-bottom: 8px;
    }
    
    .dashboard-subtitle {
        color: var(--text-color);
        font-size: 16px;
    }
    
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }
    
    .dashboard-card {
        background-color: var(--white);
        border-radius: 12px;
        box-shadow: var(--box-shadow);
        padding: 20px;
        display: flex;
        align-items: center;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background-color: var(--accent-color);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 15px;
    }
    
    .card-content {
        flex: 1;
    }
    
    .card-title {
        font-size: 18px;
        color: var(--dark-color);
        margin-bottom: 5px;
    }
    
    .card-description {
        font-size: 14px;
        color: var(--text-color);
    }
    
    .card-link {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: var(--light-color);
        color: var(--accent-color);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .card-link:hover {
        background-color: var(--accent-color);
        color: var(--white);
    }
    
    /* Responsividade para mobile */
    @media (max-width: 576px) {
        .dashboard-cards {
            grid-template-columns: 1fr;
        }
        
        .dashboard-title {
            font-size: 20px;
        }
        
        .dashboard-subtitle {
            font-size: 14px;
        }
    }
</style>
@endsection
