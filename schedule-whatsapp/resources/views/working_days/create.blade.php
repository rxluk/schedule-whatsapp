@extends('layouts.layout')

@section('title', 'Adicionar Dia Útil - AgendaZap')

@section('content')
    <div class="create-working-day-container">
        <div class="create-working-day-header">
            <h1 class="page-title">Adicionar Dia Útil</h1>
            <div class="working-day-actions">
                <a href="{{ route('working-days.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
        
        <div class="create-working-day-content">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="form-card">
                <form method="POST" action="{{ route('working-days.store') }}" class="working-day-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="day_of_week">Dia da Semana *</label>
                        <select id="day_of_week" name="day_of_week" class="form-control" required>
                            <option value="" disabled selected>Selecione o dia da semana</option>
                            <option value="1" {{ old('day_of_week') == '1' ? 'selected' : '' }}>Segunda-feira</option>
                            <option value="2" {{ old('day_of_week') == '2' ? 'selected' : '' }}>Terça-feira</option>
                            <option value="3" {{ old('day_of_week') == '3' ? 'selected' : '' }}>Quarta-feira</option>
                            <option value="4" {{ old('day_of_week') == '4' ? 'selected' : '' }}>Quinta-feira</option>
                            <option value="5" {{ old('day_of_week') == '5' ? 'selected' : '' }}>Sexta-feira</option>
                            <option value="6" {{ old('day_of_week') == '6' ? 'selected' : '' }}>Sábado</option>
                            <option value="7" {{ old('day_of_week') == '7' ? 'selected' : '' }}>Domingo</option>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="opening_time">Horário de Abertura *</label>
                            <input 
                                type="time" 
                                id="opening_time" 
                                name="opening_time" 
                                class="form-control"
                                value="{{ old('opening_time') }}"
                                required
                                step="1"
                            >
                            <small class="form-text text-muted">Formato: hh:mm:ss</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="closing_time">Horário de Fechamento *</label>
                            <input 
                                type="time" 
                                id="closing_time" 
                                name="closing_time" 
                                class="form-control"
                                value="{{ old('closing_time') }}"
                                required
                                step="1"
                            >
                            <small class="form-text text-muted">Formato: hh:mm:ss</small>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                        <a href="{{ route('working-days.index') }}" class="btn-cancel">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<style>
    .create-working-day-container {
        background-color: var(--white);
        border-radius: 12px;
        box-shadow: var(--box-shadow);
        padding: 25px;
        margin-bottom: 30px;
    }
    
    .create-working-day-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .btn-back {
        background-color: #f1f1f1;
        color: var(--text-color);
        padding: 12px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-back:hover {
        background-color: #e5e5e5;
    }
    
    .form-card {
        background-color: var(--white);
        border-radius: 12px;
        padding: 25px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-row {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .form-row .form-group {
        flex: 1;
        margin-bottom: 0;
    }
    
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--dark-color);
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        transition: border-color 0.3s;
    }
    
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23888' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 12px;
        padding-right: 35px;
    }
    
    .form-control:focus {
        border-color: var(--accent-color);
        outline: none;
    }
    
    .form-text {
        font-size: 12px;
        margin-top: 5px;
    }
    
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn-save {
        background-color: var(--accent-color);
        color: var(--white);
        padding: 12px 25px;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    
    .btn-save:hover {
        background-color: #2a92c1;
    }
    
    .btn-cancel {
        background-color: #f1f1f1;
        color: var(--text-color);
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-cancel:hover {
        background-color: #e5e5e5;
    }
    
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .error-list {
        margin: 0;
        padding-left: 20px;
    }
    
    .error-list li {
        margin-bottom: 5px;
    }
    
    .error-list li:last-child {
        margin-bottom: 0;
    }
    
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 20px;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-save, .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection