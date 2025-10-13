@extends('layouts.layout')

@section('title', 'Editar Dia Útil - AgendaZap')

@section('content')
    <div class="working-day-container">
        <div class="working-day-header">
            <h1 class="page-title">Editar Dia Útil</h1>
            <div class="working-day-actions">
                <a href="{{ route('working-days.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
        
        <div class="working-day-content">
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
                @include('working_days.partials.form', [
                    'action' => route('working-days.update', $workingDay->id),
                    'workingDay' => $workingDay,
                    'isEdit' => true,
                    'submitText' => 'Salvar Alterações'
                ])
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('working_days.partials.form_styles')
@endsection