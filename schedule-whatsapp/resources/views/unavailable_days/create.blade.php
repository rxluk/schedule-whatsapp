@extends('layouts.layout')

@section('title', 'Adicionar Dia Indisponível - AgendaZap')

@section('content')
    <div class="create-unavailable-day-container">
        <div class="create-unavailable-day-header">
            <h1 class="page-title">Adicionar Dia Indisponível</h1>
            <div class="unavailable-day-actions">
                <a href="{{ route('unavailable-days.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
        
        <div class="create-unavailable-day-content">
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
                <form method="POST" action="{{ route('unavailable-days.store') }}" class="unavailable-day-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="unavailable_date">Data *</label>
                        <input 
                            type="date" 
                            id="unavailable_date" 
                            name="unavailable_date" 
                            class="form-control" 
                            value="{{ old('unavailable_date') }}"
                            required
                        >
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="start_time">Horário de Início *</label>
                            <input 
                                type="time" 
                                id="start_time" 
                                name="start_time" 
                                class="form-control"
                                value="{{ old('start_time') }}"
                                required
                                step="1"
                            >
                            <small class="form-text text-muted">Formato: hh:mm:ss</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="end_time">Horário de Término *</label>
                            <input 
                                type="time" 
                                id="end_time" 
                                name="end_time" 
                                class="form-control"
                                value="{{ old('end_time') }}"
                                required
                                step="1"
                            >
                            <small class="form-text text-muted">Formato: hh:mm:ss</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="reason">Motivo (opcional)</label>
                        <textarea 
                            id="reason" 
                            name="reason" 
                            class="form-control" 
                            rows="3"
                            placeholder="Descreva o motivo da indisponibilidade..."
                        >{{ old('reason') }}</textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                        <a href="{{ route('unavailable-days.index') }}" class="btn-cancel">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<style>
    .create-unavailable-day-container {
        background-color: var(--white);
        border-radius: 12px;
        box-shadow: var(--box-shadow);
        padding: 25px;
        margin-bottom: 30px;
    }
    
    .create-unavailable-day-header {
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
    
    .form-control:focus {
        border-color: var(--accent-color);
        outline: none;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
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