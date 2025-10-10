@extends('layouts.layout')

@section('title', 'Dias Úteis - AgendaZap')

@section('content')
    <div class="working-days-container">
        <div class="working-days-header">
            <h1 class="page-title">Dias Úteis</h1>
            <div class="working-days-actions">
                <a href="{{ route('working-days.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i> Adicionar Dia Útil
                </a>
            </div>
        </div>
        
        <div class="working-days-content">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($workingDays->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="far fa-calendar-check"></i>
                    </div>
                    <h3>Sem dias úteis cadastrados</h3>
                    <p>Você ainda não possui nenhum dia útil cadastrado.</p>
                </div>
            @else
                <div class="working-days-list">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Dia da Semana</th>
                                    <th>Horário de Abertura</th>
                                    <th>Horário de Fechamento</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workingDays as $day)
                                    <tr>
                                        <td>
                                            @switch($day->day_of_week)
                                                @case(1)
                                                    Segunda-feira
                                                    @break
                                                @case(2)
                                                    Terça-feira
                                                    @break
                                                @case(3)
                                                    Quarta-feira
                                                    @break
                                                @case(4)
                                                    Quinta-feira
                                                    @break
                                                @case(5)
                                                    Sexta-feira
                                                    @break
                                                @case(6)
                                                    Sábado
                                                    @break
                                                @case(7)
                                                    Domingo
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($day->opening_time)->format('H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($day->closing_time)->format('H:i') }}</td>
                                        <td class="actions">
                                            <a href="{{ route('working-days.edit', $day->id) }}" class="btn-icon" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form method="POST" action="{{ route('working-days.destroy', $day->id) }}" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Tem certeza que deseja excluir este dia útil?')" title="Excluir">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<style>
    .working-days-container {
        background-color: var(--white);
        border-radius: 12px;
        box-shadow: var(--box-shadow);
        padding: 25px;
        margin-bottom: 30px;
    }
    
    .working-days-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .btn-add {
        background-color: var(--accent-color);
        color: var(--white);
        padding: 12px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-add:hover {
        background-color: #2a92c1;
        transform: translateY(-2px);
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 0;
    }
    
    .empty-icon {
        font-size: 48px;
        color: #ddd;
        margin-bottom: 15px;
    }
    
    .empty-state h3 {
        font-size: 20px;
        margin-bottom: 8px;
        color: var(--dark-color);
    }
    
    .empty-state p {
        color: var(--text-color);
    }
    
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table th, .table td {
        padding: 15px;
        text-align: left;
    }
    
    .table thead th {
        background-color: rgba(0,0,0,0.02);
        font-weight: 600;
        color: var(--dark-color);
        border-bottom: 1px solid #eee;
    }
    
    .table tbody tr {
        transition: all 0.2s;
    }
    
    .table tbody tr:hover {
        background-color: rgba(52, 183, 241, 0.05);
    }
    
    .btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: none;
        color: var(--text-color);
        text-decoration: none;
        transition: all 0.2s;
        margin-right: 5px;
    }
    
    .btn-icon:hover {
        background-color: rgba(0,0,0,0.05);
        color: var(--accent-color);
    }
    
    .btn-delete:hover {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .actions {
        white-space: nowrap;
    }
</style>
@endsection