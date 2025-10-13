<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Sistema de Agendamento WhatsApp">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AgendaZap')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Livewire Styles -->
    @livewireStyles
    
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
            --sidebar-width: 250px;
            --header-height: 70px;
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
            overflow-x: hidden;
            width: 100%;
        }

        /* Layout Components */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-color);
            color: var(--white);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand img {
            max-width: 120px;
            height: auto;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: var(--secondary-color);
            border-left-color: var(--accent-color);
        }

        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
        }

        /* Header Styles */
        .header {
            height: var(--header-height);
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .user-profile {
            position: relative;
            cursor: pointer;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
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

        .user-name {
            font-weight: 500;
            color: var(--dark-color);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: var(--white);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            min-width: 180px;
            margin-top: 10px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s;
        }

        .user-profile:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: var(--text-color);
            transition: all 0.2s;
        }

        .dropdown-menu a:hover {
            background-color: var(--light-color);
            color: var(--dark-color);
        }

        .dropdown-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Content Area */
        .content {
            padding: 30px;
        }
        
        /* Toggle Sidebar Button - Hidden by default */
        .toggle-sidebar {
            display: none; /* Escondido por padrão em todas as telas */
            background: none;
            border: none;
            color: var(--dark-color);
            font-size: 24px;
            cursor: pointer;
            margin-right: auto;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 1050;
                box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .toggle-sidebar {
                display: block; /* Mostrar apenas em telas móveis */
            }
            
            /* Overlay para quando o menu estiver ativo */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
        }

            .header {
                padding: 0 15px;
            }
        }

        /* Prevent scrolling when sidebar is open on mobile */
        body.sidebar-open {
            overflow: hidden;
        }
        
        /* Utility Classes */
        .text-primary {
            color: var(--primary-color);
        }
        
        .text-accent {
            color: var(--accent-color);
        }

        .bg-primary {
            background-color: var(--primary-color);
        }

        .bg-accent {
            background-color: var(--accent-color);
        }

        /* Additional styles can be added as needed */
        @yield('styles')
    </style>
    
    @yield('head')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar overlay (mobile only) -->
        <div class="sidebar-overlay"></div>
        
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('images/logo-white.png') }}" alt="Logo AgendaZap" class="logo">
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('appointments.index') }}" class="{{ request()->routeIs('appointments.index') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i> Agenda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('unavailable-days.index') }}" class="{{ request()->routeIs('unavailable-days.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-times"></i> Dias Indisponíveis
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('working-days.index') }}" class="{{ request()->routeIs('working-days.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i> Dias Úteis
                        </a>
                    </li>
                    <!-- Futuros itens de menu serão adicionados aqui -->
                </ul>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <button class="toggle-sidebar d-md-none">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="user-profile">
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ Auth::user()->name[0] }}
                        </div>
                        <span class="user-name d-none d-md-block">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="dropdown-menu">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.toggle-sidebar');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (toggleBtn && sidebar && overlay) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                    document.body.classList.toggle('sidebar-open');
                });
                
                // Fechar o menu quando clicar no overlay
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.classList.remove('sidebar-open');
                });
                
                // Fechar o menu ao clicar em links do menu (em dispositivos móveis)
                const menuLinks = sidebar.querySelectorAll('a');
                menuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.remove('active');
                            overlay.classList.remove('active');
                            document.body.classList.remove('sidebar-open');
                        }
                    });
                });
            }
        });
    </script>
    @yield('scripts')
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>