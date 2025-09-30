<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de Agendamento WhatsApp">
    <title>Scheduler</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <style>
        :root {
            --primary-color: #2d2c2d;
            --secondary-color: #1e1d1e;
            --accent-color: #34B7F1;
            --dark-color: #111B21;
            --light-color: #F0F2F5;
            --text-color: #54656F;
            --white: #ffffff;
            --box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        
        .login-card {
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: var(--box-shadow);
            overflow: hidden;
        }
        
        .login-header {
            padding: 24px;
            text-align: center;
        }
        
        .logo {
            max-width: 100px;
            height: auto;
            margin-bottom: 15px;
        }
        
        .login-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark-color);
            margin: 10px 0;
        }
        
        .login-subtitle {
            font-size: 14px;
            color: var(--text-color);
            margin-bottom: 5px;
        }
        
        .login-body {
            padding: 0 24px 24px;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .input-group .fa-envelope,
        .input-group .fa-lock {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            color: var(--text-color);
            z-index: 1;
        }
        
        .form-input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #ddd;
            border-radius: 10px;
            color: var(--text-color);
            background-color: var(--white);
        }
        
        input[type="password"],
        input[type="text"]#password {
            padding-right: 40px;
        }
        
        #password, #email {
        }
        
        .password-toggle {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 15px;
            cursor: pointer;
            color: var(--text-color);
            background: transparent;
            border: none;
            outline: none;
            padding: 0;
            margin: 0;
            height: 100%;
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            font-size: 16px;
            -webkit-appearance: none;
            appearance: none;
            pointer-events: all;
        }
        
        .password-toggle:focus {
            outline: none;
        }
        
        .password-toggle i {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-btn {
            width: 100%;
            padding: 15px;
            background-color: #2d2c2d;
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .login-btn:hover {
            background-color: #1e1d1e;
        }
        
        
        @media (max-width: 480px) {
            .login-container {
                padding: 15px;
                max-width: 100%;
            }
            
            .login-title {
                font-size: 20px;
            }
            
            .form-input {
                padding: 12px 12px 12px 40px;
            }
            
            .login-btn {
                padding: 12px;
            }
            
            .logo {
                max-width: 80px;
            }
        }
        
        @media (prefers-color-scheme: dark) {
            :root {
                --light-color: #111B21;
                --white: #202C33;
                --text-color: #AEBAC1;
                --box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            }
            
            .login-title {
                color: #E9EDF0;
            }
            
            .form-input {
                background-color: #2A3942;
                border-color: #374045;
                color: #E9EDF0;
            }
            
            .divider-line {
                background-color: #374045;
            }
            
            .social-btn {
                background-color: #2A3942;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="{{ asset('images/logo.png') }}" alt="Mindra Logo" class="logo">
                <h1 class="login-title">Bem-vindo ao Sistema</h1>
                <p class="login-subtitle">Faça login para acessar sua conta</p>
            </div>
            
            <div class="login-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" class="form-input" id="email" name="email" placeholder="E-mail" required value="{{ old('email') }}">
                    </div>
                    
                    @error('email')
                        <div style="color: #e74c3c; margin-bottom: 15px; font-size: 14px;">{{ $message }}</div>
                    @enderror
                    
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-input" id="password" name="password" placeholder="Senha" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Mostrar senha">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    
                    @error('password')
                        <div style="color: #e74c3c; margin-bottom: 15px; font-size: 14px;">{{ $message }}</div>
                    @enderror
                    
                    <button type="submit" class="login-btn">ENTRAR</button>
                </form>
                
            </div>
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            const selectionStart = passwordField.selectionStart;
            const selectionEnd = passwordField.selectionEnd;
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
            
            passwordField.selectionStart = selectionStart;
            passwordField.selectionEnd = selectionEnd;
        }
    </script>
</body>
</html>
