<form method="POST" action="{{ $action }}" class="working-day-form">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif
    
    <div class="form-group">
        <label for="day_of_week">Dia da Semana *</label>
        <select id="day_of_week" name="day_of_week" class="form-control" required>
            <option value="" disabled {{ !$workingDay ? 'selected' : '' }}>Selecione o dia da semana</option>
            <option value="1" {{ old('day_of_week', $workingDay->day_of_week ?? '') == '1' ? 'selected' : '' }}>Segunda-feira</option>
            <option value="2" {{ old('day_of_week', $workingDay->day_of_week ?? '') == '2' ? 'selected' : '' }}>Terça-feira</option>
            <option value="3" {{ old('day_of_week', $workingDay->day_of_week ?? '') == '3' ? 'selected' : '' }}>Quarta-feira</option>
            <option value="4" {{ old('day_of_week', $workingDay->day_of_week ?? '') == '4' ? 'selected' : '' }}>Quinta-feira</option>
            <option value="5" {{ old('day_of_week', $workingDay->day_of_week ?? '') == '5' ? 'selected' : '' }}>Sexta-feira</option>
            <option value="6" {{ old('day_of_week', $workingDay->day_of_week ?? '') == '6' ? 'selected' : '' }}>Sábado</option>
            <option value="7" {{ old('day_of_week', $workingDay->day_of_week ?? '') == '7' ? 'selected' : '' }}>Domingo</option>
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
                value="{{ old('opening_time', $workingDay ? \Carbon\Carbon::parse($workingDay->opening_time)->format('H:i:s') : '') }}"
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
                value="{{ old('closing_time', $workingDay ? \Carbon\Carbon::parse($workingDay->closing_time)->format('H:i:s') : '') }}"
                required
                step="1"
            >
            <small class="form-text text-muted">Formato: hh:mm:ss</small>
        </div>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn-save">
            <i class="fas fa-save"></i> {{ $submitText }}
        </button>
        <a href="{{ route('working-days.index') }}" class="btn-cancel">Cancelar</a>
    </div>
</form>