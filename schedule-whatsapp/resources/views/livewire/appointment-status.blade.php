<div>
    <div class="status-container">
        @if($canEdit)
            <div class="status-badge" data-status="{{ strtolower($status) }}" id="status-badge-{{ $appointmentId }}">
                {{ $status }} <i class="fas fa-chevron-down"></i>
            </div>
            
            <div class="status-dropdown" id="status-dropdown-{{ $appointmentId }}">
                @foreach($statusOptions as $option)
                    <div class="status-option" 
                         data-status="{{ strtolower($option) }}"
                         data-value="{{ $option }}">
                        {{ $option }}
                    </div>
                @endforeach
            </div>
        @else
            <div class="status-badge" data-status="{{ strtolower($status) }}">
                {{ $status }}
            </div>
        @endif
    </div>

    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    
    @if(session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <style>
        .status-container {
            position: relative;
            display: inline-block;
            z-index: 100;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            position: relative;
            z-index: 2;
        }
        
        .status-badge[data-status="agendado"] { background-color: #4CAF50; }
        .status-badge[data-status="realizado"] { background-color: #2196F3; }
        .status-badge[data-status="cancelado"] { background-color: #f44336; }
        .status-badge[data-status="não compareceu"] { background-color: #FF9800; }
        
        .status-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 5px;
            min-width: 180px;
            max-height: 200px;
            overflow-y: auto;
            overflow-x: visible;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 999999;
            display: none;
            white-space: nowrap;
        }
        
        .status-option {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f5f5f5;
            white-space: nowrap;
            width: 100%;
            box-sizing: border-box;
            overflow: visible;
        }
        
        .status-option:hover {
            background-color: #f8f9fa;
        }
        
        .status-option:last-child {
            border-bottom: none;
        }
        
        .status-option[data-status="agendado"] { border-left: 4px solid #4CAF50; }
        .status-option[data-status="realizado"] { border-left: 4px solid #2196F3; }
        .status-option[data-status="cancelado"] { border-left: 4px solid #f44336; }
        .status-option[data-status="não compareceu"] { border-left: 4px solid #FF9800; }
        
        .status-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 999998;
            display: none;
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            (function(appointmentId) {
                const badgeId = 'status-badge-' + appointmentId;
                const dropdownId = 'status-dropdown-' + appointmentId;
                
                const badge = document.getElementById(badgeId);
                const dropdown = document.getElementById(dropdownId);
                
                if (!badge || !dropdown) return;
                
                console.log('Inicializando componente para appointmentId:', appointmentId);
                
                const overlayId = 'status-overlay-' + appointmentId;
                const oldOverlay = document.getElementById(overlayId);
                if (oldOverlay) {
                    oldOverlay.remove();
                }
                
                const overlay = document.createElement('div');
                overlay.className = 'status-overlay';
                overlay.id = overlayId;
                overlay.style.pointerEvents = 'auto';
                overlay.style.background = 'transparent';
                document.body.appendChild(overlay);
            function showDropdown() {
                const rect = badge.getBoundingClientRect();
                
                document.body.appendChild(dropdown);
                
                const spaceBelow = window.innerHeight - rect.bottom;
                const spaceAbove = rect.top;
                
                const dropdownHeight = dropdown.scrollHeight || 180;
                
                const openUpwards = spaceBelow < dropdownHeight && spaceAbove > dropdownHeight;
                
                dropdown.style.position = 'fixed';
                dropdown.style.display = 'block';
                
                if (openUpwards) {
                    dropdown.style.top = 'auto';
                    dropdown.style.bottom = (window.innerHeight - rect.top + 5) + 'px';
                } else {
                    dropdown.style.top = (rect.bottom + 5) + 'px';
                    dropdown.style.bottom = 'auto';
                }
                
                dropdown.style.left = rect.left + 'px';
                dropdown.style.zIndex = '999999';
                
                dropdown.style.width = Math.max(rect.width, 180) + 'px';
                
                setTimeout(() => {
                    const options = dropdown.querySelectorAll('.status-option');
                    let maxWidth = 180;
                    
                    options.forEach(option => {
                        const text = option.textContent.trim();
                        const tempSpan = document.createElement('span');
                        tempSpan.style.visibility = 'hidden';
                        tempSpan.style.position = 'absolute';
                        tempSpan.style.whiteSpace = 'nowrap';
                        tempSpan.style.font = window.getComputedStyle(option).font;
                        tempSpan.textContent = text;
                        document.body.appendChild(tempSpan);
                        
                        const optionWidth = tempSpan.offsetWidth + 40;
                        maxWidth = Math.max(maxWidth, optionWidth);
                        
                        document.body.removeChild(tempSpan);
                    });
                    
                    dropdown.style.width = maxWidth + 'px';
                }, 0);
                
                setTimeout(() => {
                    const dropdownRect = dropdown.getBoundingClientRect();
                    if (dropdownRect.right > window.innerWidth) {
                        dropdown.style.left = 'auto';
                        dropdown.style.right = '10px';
                    }
                }, 0);
                
                overlay.style.display = 'block';
            }
            
            function hideDropdown() {
                dropdown.style.display = 'none';
                overlay.style.display = 'none';
                
                const container = badge.closest('.status-container');
                if (container && dropdown.parentNode === document.body) {
                    container.appendChild(dropdown);
                    
                    dropdown.style.position = 'absolute';
                    dropdown.style.top = '100%';
                    dropdown.style.left = '0';
                    dropdown.style.right = 'auto';
                    dropdown.style.bottom = 'auto';
                    dropdown.style.width = 'auto';
                }
            }
            
            badge.addEventListener('click', function(e) {
                e.stopPropagation();
                if (dropdown.style.display === 'block') {
                    hideDropdown();
                } else {
                    showDropdown();
                }
            });
            
            overlay.addEventListener('click', hideDropdown);
            
            dropdown.querySelectorAll('.status-option').forEach(function(option) {
                option.addEventListener('click', function() {
                    const status = this.getAttribute('data-value');
                    
                    const livewireEl = badge.closest('[wire\\:id]');
                    if (livewireEl) {
                        Livewire.find(livewireEl.getAttribute('wire:id'))
                                .call('changeStatus', status);
                    }
                    
                    badge.textContent = status + ' ';
                    badge.setAttribute('data-status', status.toLowerCase());
                    
                    const icon = document.createElement('i');
                    icon.className = 'fas fa-chevron-down';
                    badge.appendChild(icon);
                    
                    hideDropdown();
                });
            });
            
            document.addEventListener('click', function(e) {
                if (!badge.contains(e.target) && !dropdown.contains(e.target)) {
                    hideDropdown();
                }
            });
            
            if (window.Livewire) {
                const currentAppointmentId = appointmentId;
                Livewire.hook('message.processed', function(message, component) {
                    setTimeout(function() {
                        const newBadge = document.getElementById('status-badge-' + currentAppointmentId);
                        const newDropdown = document.getElementById('status-dropdown-' + currentAppointmentId);
                        const container = newBadge ? newBadge.closest('.status-container') : null;
                        
                        if (newBadge && newDropdown && container) {
                            console.log('Componente atualizado para appointmentId:', currentAppointmentId);
                            
                            if (newDropdown.parentNode !== container) {
                                container.appendChild(newDropdown);
                            }
                        }
                    }, 100);
                });
            }
        })({{ $appointmentId }});
        });
    </script>
</div>