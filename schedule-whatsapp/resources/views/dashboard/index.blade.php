<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de Agendamento WhatsApp">
    <title>Dashboard - ZapAgenda</title>

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
            --box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
        }
        
        .sidebar {
            width: 260px;
            background-color: var(--white);
            box-shadow: var(--box-shadow);
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            z-index: 100;
        }
        
        .sidebar-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .logo-small {
            max-width: 120px;
            height: auto;
            margin-bottom: 10px;
        }                .sidebar-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
            text-align: center;
        }
        
        .sidebar-nav {
            padding: 20px 0;
        }
        
        .nav-item {
            list-style: none;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(52, 183, 241, 0.1);
            color: var(--accent-color);
            border-left: 3px solid var(--accent-color);
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: var(--box-shadow);
            margin-bottom: 20px;
        }
        
        .header-title {
            font-size: 22px;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .user-menu {
            display: flex;
            align-items: center;
        }
        
        .user-info {
            margin-right: 10px;
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--primary-color);
        }
        
        .user-role {
            font-size: 12px;
            color: var(--text-color);
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--accent-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .card {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: var(--box-shadow);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        /* Form para logout */
        .logout-form {
            display: inline;
        }
        
        .logout-btn {
            background: none;
            border: none;
            color: var(--text-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            width: 100%;
            text-align: left;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }
        
        .logout-btn:hover {
            background-color: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            border-left: 3px solid #e74c3c;
        }
        
        .logout-btn i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .menu-toggle {
                display: block;
                cursor: pointer;
            }
            
            .header {
                position: relative;
            }
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        
        .col-md-6 {
            width: 100%;
            padding: 0 10px;
        }
        
        @media (min-width: 768px) {
            .col-md-6 {
                width: 50%;
            }
        }
        
        @media (prefers-color-scheme: dark) {
            :root {
                --light-color: #111B21;
                --white: #202C33;
                --text-color: #AEBAC1;
                --primary-color: #E9EDF0;
                --box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            }
            
            .nav-link:hover, .nav-link.active {
                background-color: rgba(52, 183, 241, 0.05);
            }
            
            .logout-btn:hover {
                background-color: rgba(231, 76, 60, 0.05);
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-small">
            <h2 class="sidebar-title">ZapAgenda</h2>
        </div>
        
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Agendamentos</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-address-book"></i>
                    <span>Contatos</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Configurações</span>
                </a>
            </li>
            
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sair</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <div class="d-flex align-items-center">
                <span class="menu-toggle d-md-none me-3" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </span>
                <h1 class="header-title">Dashboard</h1>
            </div>
            
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-name">{{ $user->email }}</div>
                    <div class="user-role">{{ $user->permission_level }}</div>
                </div>
                
                <div class="avatar">
                    {{ substr($user->email, 0, 1) }}
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2 class="card-title">Bem-vindo ao ZapAgenda!</h2>
            <p>Este é o seu painel de controle para gerenciar agendamentos de mensagens no WhatsApp.</p>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <h3 class="card-title">Mensagens Agendadas</h3>
                    <p>Você não tem mensagens agendadas no momento.</p>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <h3 class="card-title">Atividade Recente</h3>
                    <p>Nenhuma atividade recente para mostrar.</p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        
        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
        }
    </script>
</body>
</html>