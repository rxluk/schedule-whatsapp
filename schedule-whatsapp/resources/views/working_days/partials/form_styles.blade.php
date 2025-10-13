{{-- Estilos compartilhados para formulários de dias úteis --}}
<style>
    .working-day-container {
        background-color: var(--white);
        border-radius: 12px;
        box-shadow: var(--box-shadow);
        padding: 25px;
        margin-bottom: 30px;
    }
    
    .working-day-header {
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
    
    .btn-back {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-color);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }
    
    .btn-back:hover {
        color: var(--primary-color);
    }
    
    .form-card {
        background-color: var(--white);
        border-radius: 12px;
        padding: 25px;
    }
    
    .working-day-form {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .form-row {
        display: flex;
        gap: 20px;
    }
    
    .form-row .form-group {
        flex: 1;
    }
    
    label {
        font-weight: 500;
        color: var(--dark-color);
    }
    
    .form-control {
        padding: 12px;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        font-size: 16px;
        color: var(--text-color);
        width: 100%;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
    }
    
    .form-text {
        font-size: 13px;
        color: #6c757d;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 15px;
        margin-top: 10px;
    }
    
    .btn-save {
        display: flex;
        align-items: center;
        gap: 10px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 12px 25px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s;
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