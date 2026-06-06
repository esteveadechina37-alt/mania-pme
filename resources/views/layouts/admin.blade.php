<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Mania-PME')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=clash-display:400,500,600,700|cabinet-grotesk:400,500,700,800" rel="stylesheet" />

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --orange: #FF6200;
            --orange-light: #FF8C42;
            --black: #0A0A0A;
            --white: #FFFFFF;
            --gray-light: #F7F4F0;
            --text-muted: #6B6B6B;
            --sidebar-width: 260px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Cabinet Grotesk', sans-serif;
            background: var(--gray-light);
            color: var(--black);
            display: flex;
            min-height: 100vh;
        }

        /* ========== SIDEBAR PREMIUM ========== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0a0a0a 0%, #141414 100%);
            color: var(--white);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            box-shadow: 8px 0 30px rgba(0,0,0,0.3);
            padding: 24px 0 0;
            transition: transform 0.3s ease;
        }

        .sidebar-logo {
            padding: 0 20px 24px;
            margin: 0 0 8px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
        }
        .sidebar-logo a {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
        }
        .sidebar-logo span {
            font-family: 'Clash Display', sans-serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.3px;
            color: #fff;
            transition: color 0.2s;
        }
        .sidebar-logo:hover span { color: var(--orange-light); }

        .sidebar-nav {
            flex: 1;
            padding: 8px 12px 0;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.15) transparent;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.15);
            border-radius: 4px;
        }

        .nav-section { margin-bottom: 20px; }
        .nav-title {
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.8px;
            color: rgba(255,255,255,0.35);
            margin: 12px 8px 8px;
            padding: 0 4px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 2px;
            transition: all 0.2s ease;
            position: relative;
        }
        .sidebar-nav a i {
            width: 18px;
            font-size: 15px;
            color: inherit;
            text-align: center;
            transition: color 0.2s;
        }

        .sidebar-nav a:hover {
            background: rgba(255,98,0,0.12);
            color: #fff;
            transform: translateX(2px);
        }
        .sidebar-nav a:hover i { color: var(--orange); }

        /* Lien actif */
        .sidebar-nav a.active {
            background: linear-gradient(135deg, rgba(255,98,0,0.25) 0%, rgba(255,140,66,0.15) 100%);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(255,98,0,0.15);
            border: 1px solid rgba(255,98,0,0.3);
        }
        .sidebar-nav a.active i { color: var(--orange); }
        .sidebar-nav a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 20px;
            width: 3px;
            background: var(--orange);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
            margin-top: auto;
            background: rgba(0,0,0,0.2);
            backdrop-filter: blur(8px);
        }
        .sidebar-footer a {
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .sidebar-footer a i { font-size: 14px; }
        .sidebar-footer a:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }
        .sidebar-footer a:hover i { color: var(--orange); }

        /* ========== TOPBAR ========== */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: 72px;
            background: var(--white);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            z-index: 90;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; font-size: 15px; color: var(--text-muted); }
        .topbar-right { display: flex; align-items: center; gap: 24px; }
        .topbar-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, var(--orange) 0%, var(--orange-light) 100%);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px;
            box-shadow: 0 4px 12px rgba(255,98,0,0.3);
        }
        .topbar-user { font-weight: 600; color: var(--black); font-size: 14px; }
        .topbar-logout {
            background: none; border: none; color: var(--text-muted); cursor: pointer;
            font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 6px;
            transition: color 0.2s;
        }
        .topbar-logout:hover { color: var(--orange); }

        /* Burger menu (mobile) */
        .burger-btn {
            display: none;
            background: none;
            border: none;
            color: var(--black);
            font-size: 24px;
            cursor: pointer;
            padding: 8px;
            margin-right: 16px;
            transition: color 0.2s;
        }
        .burger-btn:hover { color: var(--orange); }

        /* MAIN CONTENT */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 72px;
            padding: 32px;
            flex: 1;
            min-height: calc(100vh - 72px);
        }

        /* Overlay pour mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            backdrop-filter: blur(2px);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .sidebar-overlay.show {
                display: block;
            }
            .topbar {
                left: 0;
                padding: 0 20px;
            }
            .main-content {
                margin-left: 0;
            }
            .burger-btn {
                display: block;
            }
            .topbar-left > i {
                display: none; /* cache l'icône building sur mobile pour faire de la place */
            }
        }
    </style>
</head>
<body>
    <!-- Overlay mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="{{ url('/') }}">
                <svg width="32" height="32" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="logoGradSide" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#FF6200"/>
                            <stop offset="100%" style="stop-color:#FF8C42"/>
                        </linearGradient>
                    </defs>
                    <rect width="38" height="38" rx="9" fill="url(#logoGradSide)"/>
                    <path d="M8 25V12L18 19.5L28 12V25"
                        stroke="white" stroke-width="2.6"
                        stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    <circle cx="28" cy="25" r="2.2" fill="white" fill-opacity="0.9"/>
                    <line x1="9" y1="25" x2="17.5" y2="25" stroke="white" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
                </svg>
                <span>Mania-PME</span>
            </a>
        </div>

        <nav class="sidebar-nav">
            @role('admin')
            <div class="nav-section">
                <div class="nav-title">Principal</div>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Tableau de bord
                </a>
                <!-- <a href=""><i class="fas fa-users"></i> Employés</a> -->
                 <a href="{{ route('admin.employees.index') }}" class="{{ request()->routeIs('admin.employees.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Employés</a>
                <!-- <a href="#"><i class="fas fa-sitemap"></i> Départements</a> -->
                 <a href="{{ route('admin.departments.index') }}" class="{{ request()->routeIs('admin.departments.*') ? 'active' : '' }}"><i class="fas fa-sitemap"></i> Départements</a>
            </div>
            <div class="nav-section">
                <div class="nav-title">Ressources Humaines</div>
                <!-- <a href="#"><i class="fas fa-calendar-alt"></i> Congés & Absences</a> -->
                <a href="{{ route('admin.leave-types.index') }}" class="{{ request()->routeIs('admin.leave-types.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Types de congés
                </a>
                <!-- <a href="{{ route('leave-requests.pending') }}" class="{{ request()->routeIs('leave-requests.pending') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Congés en attente
                </a> -->
                <a href="{{ route('attendances.list') }}" class="{{ request()->routeIs('attendances.list') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> Présences
                </a>
                <a href="{{ route('admin.evaluations.index') }}" class="{{ request()->routeIs('admin.evaluations.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> Évaluations
                </a>
                <a href="{{ route('admin.payslips.index') }}" class="{{ request()->routeIs('admin.payslips.*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave"></i> Paie
                </a>
                <a href="{{ route('admin.documents.index') }}" class="{{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> Documents
                </a>
                <a href="{{ route('admin.contracts.index') }}" class="{{ request()->routeIs('admin.contracts.*') ? 'active' : '' }}">
                    <i class="fas fa-file-contract"></i> Contrats
                </a>
            </div>

            <!-- <div class="nav-section"> -->
                <!-- <div class="nav-title">Ressources</div>
                <a href="#"><i class="fas fa-question-circle"></i> Aide</a>

                <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Paramètres
                </a> -->
            <!-- </div> -->
            @endrole

            @role('manager')
            <div class="nav-section">
                <div class="nav-title">Gestion d'équipe</div>
                <a href="{{ route('manager.dashboard') }}" class="{{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Tableau de bord
                </a>
                <a href="{{ route('manager.team') }}" class="{{ request()->routeIs('manager.team') ? 'active' : '' }}">
                    <i class="fas fa-user-friends"></i> Mon équipe
                </a>
                <a href="{{ route('admin.evaluations.index') }}" class="{{ request()->routeIs('admin.evaluations.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> Evaluations
                </a>
                <a href="{{ route('leave-requests.pending') }}" class="{{ request()->routeIs('leave-requests.pending') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Validation congés
                </a>
                <a href="{{ route('attendances.list') }}" class="{{ request()->routeIs('attendances.list') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> Présences
                </a>
                <!-- <a href="#"><i class="fas fa-calendar-check"></i> Validation congés</a> -->
            </div>

              <!-- <div class="nav-section">
                <div class="nav-title">Ressources</div>
                <a href="#"><i class="fas fa-question-circle"></i> Aide</a>
                <a href="#"><i class="fas fa-cog"></i> Paramètres</a>
            </div> -->
            @endrole

            @role('employe')
            <div class="nav-section">
                <div class="nav-title">Mon espace</div>
                <a href="{{ route('employee.dashboard') }}" class="{{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Tableau de bord
                </a>
                <a href="{{ route('employee.profile') }}" class="{{ request()->routeIs('employee.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> Mon profil
                </a>
                <a href="{{ route('leave-requests.create') }}" class="{{ request()->routeIs('leave-requests.create') ? 'active' : '' }}">
                    <i class="fas fa-calendar-plus"></i> Demande de congé
                </a>
                <a href="{{ route('leave-requests.index') }}" class="{{ request()->routeIs('leave-requests.index') ? 'active' : '' }}">
                    <i class="fas fa-list-alt"></i> Mes demandes
                </a>
                <a href="{{ route('attendances.index') }}" class="{{ request()->routeIs('attendances.index') ? 'active' : '' }}">
                    <i class="fas fa-user-check"></i> Pointage
                </a>
                <a href="{{ route('attendances.history') }}" class="{{ request()->routeIs('attendances.history') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Historique
                </a>
                <!-- <a href="#"><i class="fas fa-calendar-plus"></i> Demande de congé</a> -->
                <a href="{{ route('employee.payslips.index') }}" class="{{ request()->routeIs('employee.payslips.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i> 
                    Mes bulletins</a> 
                <a href="{{ route('employee.evaluations.index') }}" class="{{ request()->routeIs('employee.evaluations.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> Mes évaluations
                </a>
                <a href="{{ route('employee.documents.index') }}" class="{{ request()->routeIs('employee.documents.index') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> Mes documents</a>
            </div>

              <!-- <div class="nav-section">
                <div class="nav-title">Ressources</div>
                <a href="#"><i class="fas fa-question-circle"></i> Aide</a>
                <a href="#"><i class="fas fa-cog"></i> Paramètres</a>
            </div> -->
            @endrole

            @role('stagiaire')
            <div class="nav-section">
                <div class="nav-title">Espace Stagiaire</div>
                <a href="{{ route('employee.dashboard') }}" class="{{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Tableau de bord
                </a>
                <a href="{{ route('employee.internship') }}" class="{{ request()->routeIs('employee.internship') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i> Mon stage
                </a>
                <a href="{{ route('leave-requests.create') }}" class="{{ request()->routeIs('leave-requests.create') ? 'active' : '' }}">
                    <i class="fas fa-calendar-plus"></i> Demande de congé
                </a>
                <a href="{{ route('leave-requests.index') }}" class="{{ request()->routeIs('leave-requests.index') ? 'active' : '' }}">
                    <i class="fas fa-list-alt"></i> Mes demandes
                </a>
                <a href="{{ route('attendances.index') }}" class="{{ request()->routeIs('attendances.index') ? 'active' : '' }}">
                    <i class="fas fa-user-check"></i> Pointage
                </a>
                <a href="{{ route('attendances.history') }}" class="{{ request()->routeIs('attendances.history') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Historique
                </a>
                <a href="{{ route('employee.documents.index') }}" class="{{ request()->routeIs('employee.documents.index') ? 'active' : '' }}">
                    <i class="fas fa-file-signature"></i> Attestations
                </a>
                <a href="{{ route('employee.evaluations.index') }}" class="{{ request()->routeIs('employee.evaluations.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> Mes évaluations
                </a>
            </div>

              <!-- <div class="nav-section">
                <div class="nav-title">Ressources</div>
                <a href="#"><i class="fas fa-question-circle"></i> Aide</a>
                <a href="#"><i class="fas fa-cog"></i> Paramètres</a>
            </div> -->
            @endrole

            <!-- <div class="nav-section">
                <div class="nav-title">Ressources</div>
                <a href="#"><i class="fas fa-question-circle"></i> Aide</a>
                <a href="#"><i class="fas fa-cog"></i> Paramètres</a>
            </div> -->

            <div class="nav-section">
                <div class="nav-title">Ressources</div>
                <a href="#"><i class="fas fa-question-circle"></i> Aide</a>
                <a href="{{ route('user.settings.edit') }}" class="{{ request()->routeIs('user.settings.edit') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i> Mon compte
                </a>
                @role('admin')
                    <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.edit') ? 'active' : '' }}">
                        <i class="fas fa-building"></i> Entreprise
                    </a>
                @endrole
            </div>
        </nav>

        <div class="sidebar-footer">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>
    </aside>

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="topbar-left">
            <button class="burger-btn" onclick="toggleSidebar()" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>
            <i class="fas fa-building" style="color:var(--orange);"></i>
            <span>{{ auth()->user()->company->name ?? 'Mania-PME' }}</span>
        </div>
        <div class="topbar-right">
            {{-- Cloche de notifications --}}
        @php
            $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                            ->whereNull('read_at')
                            ->count();
            $latestNotifications = \App\Models\Notification::where('user_id', auth()->id())
                                    ->latest()
                                    ->take(5)
                                    ->get();
        @endphp

        <div class="notification-bell" style="position: relative; margin-right: 16px; cursor: pointer;" onclick="toggleNotifications()">
            <i class="fas fa-bell" style="font-size: 18px; color: var(--gray-600);"></i>
            @if($unreadCount > 0)
                <span style="position: absolute; top: -6px; right: -8px; background: #EF4444; color: white; width: 18px; height: 18px; border-radius: 50%; font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center;">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            @endif

            {{-- Panneau déroulant --}}
            <div id="notifPanel" class="notif-panel" style="display: none; position: absolute; top: 40px; right: 0; width: 320px; max-height: 400px; overflow-y: auto; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-lg); border: 1px solid var(--gray-200); z-index: 1001;">
                <div style="padding: 16px; border-bottom: 1px solid var(--gray-100); font-weight: 600; color: var(--dark);">
                    Notifications
                </div>
                @forelse($latestNotifications as $notif)
                    <div style="padding: 12px 16px; border-bottom: 1px solid var(--gray-50); {{ is_null($notif->read_at) ? 'background: var(--primary-light);' : '' }}">
                        <p style="margin: 0; font-size: 13px; font-weight: 600;">{{ $notif->title }}</p>
                        <p style="margin: 4px 0 0; font-size: 12px; color: var(--gray-600);">{{ \Illuminate\Support\Str::limit($notif->message, 60) }}</p>
                        <small style="color: var(--gray-400);">{{ $notif->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <div style="padding: 20px; text-align: center; color: var(--gray-600);">
                        Aucune notification.
                    </div>
                @endforelse
                @if($latestNotifications->isNotEmpty())
                    <div style="padding: 12px 16px; text-align: center; border-top: 1px solid var(--gray-100);">
                        <a href="{{ route('notifications.index') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Voir toutes mes notifications</a>
                    </div>
                @endif
            </div>
        </div>

        <script>
            function toggleNotifications() {
                var panel = document.getElementById('notifPanel');
                panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
            }

            // Fermer le panneau si clic en dehors
            document.addEventListener('click', function(e) {
                var bell = document.querySelector('.notification-bell');
                var panel = document.getElementById('notifPanel');
                if (!bell.contains(e.target)) {
                    panel.style.display = 'none';
                }
            });
        </script>

        @role('admin|super-admin')
        <div class="employee-search" style="position: relative; margin-right: 16px;">
            <input type="text" id="employeeSearchInput" placeholder="Rechercher un employé..." 
                style="padding: 8px 14px; border: 1px solid var(--gray-200); border-radius: var(--radius-full); 
                        font-size: 13px; width: 220px; outline: none; background: var(--white); 
                        color: var(--dark); font-family: 'Cabinet Grotesk', sans-serif;"
                autocomplete="off">
            <div id="employeeSearchResults" style="display: none; position: absolute; top: 44px; left: 0; width: 320px; 
                        background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-lg); 
                        border: 1px solid var(--gray-200); z-index: 1002; max-height: 300px; overflow-y: auto;"></div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('employeeSearchInput');
            const resultsDiv = document.getElementById('employeeSearchResults');
            let debounceTimer;

            if (!input) return;

            input.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = this.value.trim();
                if (query.length < 2) {
                    resultsDiv.style.display = 'none';
                    return;
                }
                debounceTimer = setTimeout(() => {
                    fetch(`/admin/employees/search?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(employees => {
                            if (employees.length === 0) {
                                resultsDiv.innerHTML = '<div style="padding:12px; color:var(--gray-600);">Aucun employé trouvé.</div>';
                            } else {
                                resultsDiv.innerHTML = employees.map(emp => 
                                    `<a href="/admin/employees/${emp.id}" style="display:flex; align-items:center; gap:12px; padding:10px 14px; text-decoration:none; color:var(--dark); border-bottom:1px solid var(--gray-100);">
                                        <div style="width:32px; height:32px; border-radius:8px; background:linear-gradient(135deg, var(--primary), var(--primary-hover)); color:white; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px;">${emp.name.charAt(0).toUpperCase()}</div>
                                        <div>
                                            <div style="font-weight:600;">${emp.name}</div>
                                            <div style="font-size:12px; color:var(--gray-600);">${emp.position || 'Sans poste'} · ${emp.department || '—'}</div>
                                        </div>
                                    </a>`
                                ).join('');
                            }
                            resultsDiv.style.display = 'block';
                        });
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !resultsDiv.contains(e.target)) {
                    resultsDiv.style.display = 'none';
                }
            });
        });
        </script>
        @endrole
            <div class="topbar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <span class="topbar-user">{{ auth()->user()->name }}</span>
            <button class="topbar-logout" onclick="document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off"></i>
            </button>
        </div>
    </header>

    <!-- CONTENU PRINCIPAL -->
    <main class="main-content">
        @yield('content')
    </main>

    @stack('scripts')

    {{-- Script pour le menu burger --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }
        // Fermer si on redimensionne au-dessus du breakpoint mobile
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('show');
            }
        });
    </script>


<!-- Modal de confirmation global -->
@include('components.confirm-modal')

<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function openConfirmModal(url) {
        const modal = document.getElementById('confirmModal');
        const form = document.getElementById('deleteForm');
        form.action = url;
        modal.style.display = 'flex';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modalCancel = document.getElementById('modalCancel');
        const modalConfirm = document.getElementById('modalConfirm');
        const modal = document.getElementById('confirmModal');

        if (modalCancel) {
            modalCancel.addEventListener('click', function() {
                modal.style.display = 'none';
            });
        }

        if (modalConfirm) {
            modalConfirm.addEventListener('click', function() {
                document.getElementById('deleteForm').submit();
            });
        }

        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        }
    });
</script>

</body>
</html>