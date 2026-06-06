<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mania-PME')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=clash-display:400,500,600,700|cabinet-grotesk:400,500,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --orange: #FF6200;
            --orange-light: #FF8C42;
            --black: #0A0A0A;
            --white: #FFFFFF;
            --gray-light: #F7F4F0;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-600: #6B7280;
            --text-muted: #6B6B6B;
            --sidebar-width: 260px;
            --topbar-height: 64px;
            --primary: #FF6200;
            --primary-hover: #E05500;
            --primary-light: rgba(255,98,0,0.08);
            --dark: #0A0A0A;
            --shadow-lg: 0 16px 40px rgba(0,0,0,0.12);
            --radius-md: 14px;
            --radius-full: 9999px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Cabinet Grotesk', sans-serif;
            background: var(--gray-light);
            color: var(--black);
            display: flex;
            min-height: 100vh;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0a0a0a 0%, #141414 100%);
            color: var(--white);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex; flex-direction: column;
            z-index: 1000;
            box-shadow: 8px 0 30px rgba(0,0,0,0.3);
            padding: 24px 0 0;
            transition: transform 0.3s ease;
        }
        .sidebar-logo {
            padding: 0 20px 24px;
            margin: 0 0 8px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center;
        }
        .sidebar-logo a { display: flex; align-items: center; gap: 10px; text-decoration: none; color: white; }
        .sidebar-logo span {
            font-family: 'Clash Display', sans-serif;
            font-size: 20px; font-weight: 700; letter-spacing: -0.3px; color: #fff; transition: color 0.2s;
        }
        .sidebar-logo:hover span { color: var(--orange-light); }
        .sidebar-nav {
            flex: 1; padding: 8px 12px 0; overflow-y: auto;
            scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.15) transparent;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }
        .nav-section { margin-bottom: 20px; }
        .nav-title {
            text-transform: uppercase; font-size: 10px; font-weight: 700;
            letter-spacing: 1.8px; color: rgba(255,255,255,0.35); margin: 12px 8px 8px; padding: 0 4px;
        }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 10px; padding: 10px 12px;
            border-radius: 10px; color: rgba(255,255,255,0.6); text-decoration: none;
            font-size: 13.5px; font-weight: 500; margin-bottom: 2px;
            transition: all 0.2s ease; position: relative;
        }
        .sidebar-nav a i { width: 18px; font-size: 15px; color: inherit; text-align: center; transition: color 0.2s; }
        .sidebar-nav a:hover { background: rgba(255,98,0,0.12); color: #fff; transform: translateX(2px); }
        .sidebar-nav a:hover i { color: var(--orange); }
        .sidebar-nav a.active {
            background: linear-gradient(135deg, rgba(255,98,0,0.25) 0%, rgba(255,140,66,0.15) 100%);
            color: #fff; font-weight: 600;
            box-shadow: 0 4px 12px rgba(255,98,0,0.15);
            border: 1px solid rgba(255,98,0,0.3);
        }
        .sidebar-nav a.active i { color: var(--orange); }
        .sidebar-nav a.active::before {
            content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
            height: 20px; width: 3px; background: var(--orange); border-radius: 0 4px 4px 0;
        }
        .sidebar-footer {
            padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.06);
            margin-top: auto; background: rgba(0,0,0,0.2); backdrop-filter: blur(8px);
        }
        .sidebar-footer a {
            color: rgba(255,255,255,0.5); text-decoration: none; font-size: 12.5px; font-weight: 500;
            display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 8px; transition: all 0.2s;
        }
        .sidebar-footer a:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .sidebar-footer a:hover i { color: var(--orange); }

        /* ========== TOPBAR ========== */
        .topbar {
            position: fixed;
            top: 0; left: var(--sidebar-width); right: 0;
            height: var(--topbar-height);
            background: var(--white);
            border-bottom: 1px solid rgba(0,0,0,0.06);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px; z-index: 90;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            gap: 12px;
        }

        /* Gauche */
        .topbar-left {
            display: flex; align-items: center; gap: 10px;
            min-width: 0; flex: 1;
        }
        .burger-btn {
            display: none; background: none; border: none;
            color: var(--black); font-size: 22px; cursor: pointer;
            padding: 6px; border-radius: 8px; transition: all 0.2s; flex-shrink: 0;
        }
        .burger-btn:hover { background: var(--gray-100); color: var(--orange); }
        .topbar-company {
            display: flex; align-items: center; gap: 8px; min-width: 0;
        }
        .topbar-company i { color: var(--orange); font-size: 15px; flex-shrink: 0; }
        .topbar-company-name {
            font-weight: 800; /* ✅ gras */
            color: var(--black); font-size: 14px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            max-width: 200px;
        }

        /* Droite */
        .topbar-right {
            display: flex; align-items: center; gap: 6px; flex-shrink: 0;
        }

        /* Recherche */
        .topbar-search { position: relative; }
        .topbar-search input {
            padding: 8px 14px 8px 36px;
            border: 1px solid var(--gray-200); border-radius: var(--radius-full);
            font-size: 13px; width: 200px; outline: none;
            background: var(--gray-50); color: var(--dark);
            font-family: 'Cabinet Grotesk', sans-serif;
            transition: all 0.25s;
        }
        .topbar-search input:focus {
            border-color: var(--orange); background: white;
            box-shadow: 0 0 0 3px rgba(255,98,0,0.08); width: 240px;
        }
        .topbar-search .search-icon {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: var(--gray-300); font-size: 13px; pointer-events: none;
        }
        #employeeSearchResults {
            display: none; position: absolute; top: 44px; left: 0; width: 300px;
            background: white; border-radius: 14px; box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200); z-index: 1002; max-height: 280px; overflow-y: auto;
        }

        /* Bouton icône */
        .topbar-icon-btn {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--gray-50); border: 1px solid var(--gray-200);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; color: var(--gray-600); cursor: pointer;
            transition: all 0.2s; position: relative; flex-shrink: 0;
        }
        .topbar-icon-btn:hover { background: var(--primary-light); color: var(--orange); border-color: var(--orange); }

        /* Badge notif */
        .notif-badge {
            position: absolute; top: -5px; right: -5px;
            background: #EF4444; color: white;
            width: 18px; height: 18px; border-radius: 50%;
            font-size: 9px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid white;
        }

        /* Panneau notifications */
        .notif-panel {
            display: none; position: absolute; top: 48px; right: 0;
            width: 320px; max-height: 400px; overflow-y: auto;
            background: white; border-radius: 16px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200); z-index: 1001;
        }
        .notif-header {
            padding: 14px 16px; border-bottom: 1px solid var(--gray-100);
            display: flex; align-items: center; justify-content: space-between;
            font-weight: 700; font-size: 14px; color: var(--black); position: sticky; top: 0; background: white;
        }
        .notif-count {
            font-size: 11px; font-weight: 600; color: var(--orange);
            background: var(--primary-light); padding: 2px 8px; border-radius: 20px;
        }
        .notif-item {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 12px 16px; border-bottom: 1px solid var(--gray-100); transition: background 0.15s;
        }
        .notif-item:hover { background: var(--gray-50); }
        .notif-item.unread { background: rgba(255,98,0,0.03); }
        .notif-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--gray-200); flex-shrink: 0; margin-top: 4px; }
        .notif-dot.active { background: var(--orange); }
        .notif-body { flex: 1; min-width: 0; }
        .notif-title { font-size: 13px; font-weight: 600; color: var(--black); margin: 0 0 2px; }
        .notif-msg { font-size: 12px; color: var(--text-muted); margin: 0 0 3px; }
        .notif-time { font-size: 11px; color: var(--gray-300); }
        .notif-empty { padding: 28px; text-align: center; color: var(--text-muted); }
        .notif-empty i { font-size: 26px; opacity: .3; display: block; margin-bottom: 8px; }
        .notif-empty p { margin: 0; font-size: 13px; }
        .notif-footer {
            padding: 12px 16px; text-align: center;
            border-top: 1px solid var(--gray-100); position: sticky; bottom: 0; background: white;
        }
        .notif-footer a { color: var(--orange); font-weight: 600; font-size: 13px; text-decoration: none; }

        /* Dropdown utilisateur */
        .topbar-user-menu {
            display: flex; align-items: center; gap: 8px; cursor: pointer;
            position: relative; padding: 5px 10px; border-radius: 10px; transition: background 0.2s;
        }
        .topbar-user-menu:hover { background: var(--gray-50); }
        .topbar-avatar {
            width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, var(--orange) 0%, var(--orange-light) 100%);
            color: white; display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; box-shadow: 0 3px 8px rgba(255,98,0,0.3);
        }
        .topbar-user-name {
            font-weight: 600; color: var(--black); font-size: 13px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px;
        }
        .topbar-chevron { font-size: 10px; color: var(--text-muted); transition: transform 0.2s; }
        .topbar-user-menu.open .topbar-chevron { transform: rotate(180deg); }

        .user-menu-panel {
            display: none; position: absolute; top: 50px; right: 0;
            width: 230px; background: white; border-radius: 14px;
            box-shadow: var(--shadow-lg); border: 1px solid var(--gray-200); z-index: 1001; overflow: hidden;
        }
        .user-menu-header {
            display: flex; align-items: center; gap: 10px;
            padding: 14px 16px; background: var(--gray-50); border-bottom: 1px solid var(--gray-100);
        }
        .user-menu-avatar {
            width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;
        }
        .user-menu-header strong { font-size: 13px; color: var(--black); display: block; }
        .user-menu-header small { font-size: 11px; color: var(--text-muted); }
        .user-menu-body { padding: 6px; }
        .user-menu-item {
            display: flex; align-items: center; gap: 9px; padding: 9px 12px;
            border-radius: 8px; font-size: 13px; color: var(--black);
            text-decoration: none; transition: background 0.15s; font-weight: 500;
        }
        .user-menu-item i { width: 16px; text-align: center; color: var(--text-muted); }
        .user-menu-item:hover { background: var(--gray-50); }
        .user-menu-item.danger { color: #EF4444; }
        .user-menu-item.danger i { color: #EF4444; }
        .user-menu-item.danger:hover { background: #FEF2F2; }
        .user-menu-divider { height: 1px; background: var(--gray-100); margin: 4px 0; }

        /* ========== MAIN ========== */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 28px;
            flex: 1;
            min-height: calc(100vh - var(--topbar-height));
            min-width: 0;
        }

        /* Overlay mobile */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 999; backdrop-filter: blur(2px);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .topbar-search input { width: 160px; }
            .topbar-search input:focus { width: 200px; }
            .topbar-company-name { max-width: 140px; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .topbar { left: 0; padding: 0 14px; }
            .main-content { margin-left: 0; padding: 16px; }
            .burger-btn { display: flex; }
            /* Cacher les éléments non essentiels */
            .topbar-search { display: none; }
            .topbar-user-name { display: none; }
            .topbar-chevron { display: none; }
            .topbar-company i { display: none; }
            .topbar-company-name { max-width: 130px; font-size: 13px; }
            .topbar-user-menu { padding: 4px 6px; }
            /* Panneaux adaptés mobile */
            .notif-panel { width: min(300px, calc(100vw - 20px)); right: -40px; }
            .user-menu-panel { width: 210px; }
        }

        @media (max-width: 400px) {
            .topbar { padding: 0 10px; }
            .topbar-company-name { max-width: 90px; font-size: 12px; }
            .notif-panel { right: -70px; }
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
                <path d="M8 25V12L18 19.5L28 12V25" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
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
            <a href="{{ route('admin.employees.index') }}" class="{{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Employés
            </a>
            <a href="{{ route('admin.departments.index') }}" class="{{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                <i class="fas fa-sitemap"></i> Départements
            </a>
        </div>
        <div class="nav-section">
            <div class="nav-title">Ressources Humaines</div>
            <a href="{{ route('admin.leave-types.index') }}" class="{{ request()->routeIs('admin.leave-types.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Types de congés
            </a>
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
        </div>
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
            <a href="{{ route('employee.payslips.index') }}" class="{{ request()->routeIs('employee.payslips.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> Mes bulletins
            </a>
            <a href="{{ route('employee.evaluations.index') }}" class="{{ request()->routeIs('employee.evaluations.*') ? 'active' : '' }}">
                <i class="fas fa-star"></i> Mes évaluations
            </a>
            <a href="{{ route('employee.documents.index') }}" class="{{ request()->routeIs('employee.documents.index') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Mes documents
            </a>
        </div>
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
        @endrole

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

<!-- ========== TOPBAR ========== -->
<header class="topbar">

    {{-- Gauche : burger + nom entreprise --}}
    <div class="topbar-left">
        <button class="burger-btn" onclick="toggleSidebar()" aria-label="Menu">
            <i class="fas fa-bars"></i>
        </button>
        <div class="topbar-company">
            <i class="fas fa-building"></i>
            <span class="topbar-company-name">{{ auth()->user()->company->name ?? 'Mania-PME' }}</span>
        </div>
    </div>

    {{-- Droite : recherche + notif + user --}}
    <div class="topbar-right">

        {{-- Recherche (admin seulement) --}}
        @role('admin|super-admin')
        <div class="topbar-search">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="employeeSearchInput" placeholder="Rechercher un employé..." autocomplete="off">
            <div id="employeeSearchResults"></div>
        </div>
        @endrole

        {{-- Notifications --}}
        @php
            $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->whereNull('read_at')->count();
            $latestNotifications = \App\Models\Notification::where('user_id', auth()->id())->latest()->take(5)->get();
        @endphp

        <div style="position:relative;">
            <div class="topbar-icon-btn" onclick="toggleNotifications(event)">
                <i class="fas fa-bell"></i>
                @if($unreadCount > 0)
                    <span class="notif-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                @endif
            </div>
            <div id="notifPanel" class="notif-panel">
                <div class="notif-header">
                    <span>Notifications</span>
                    @if($unreadCount > 0)
                        <span class="notif-count">{{ $unreadCount }} non lue(s)</span>
                    @endif
                </div>
                @forelse($latestNotifications as $notif)
                    <div class="notif-item {{ is_null($notif->read_at) ? 'unread' : '' }}">
                        <div class="notif-dot {{ is_null($notif->read_at) ? 'active' : '' }}"></div>
                        <div class="notif-body">
                            <p class="notif-title">{{ $notif->title }}</p>
                            <p class="notif-msg">{{ \Illuminate\Support\Str::limit($notif->message, 60) }}</p>
                            <small class="notif-time">{{ $notif->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @empty
                    <div class="notif-empty">
                        <i class="fas fa-bell-slash"></i>
                        <p>Aucune notification</p>
                    </div>
                @endforelse
                @if($latestNotifications->isNotEmpty())
                    <div class="notif-footer">
                        <a href="{{ route('notifications.index') }}">Voir toutes les notifications</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Utilisateur --}}
        <div class="topbar-user-menu" id="userMenuTrigger" onclick="toggleUserMenu(event)">
            <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <span class="topbar-user-name">{{ auth()->user()->name }}</span>
            <i class="fas fa-chevron-down topbar-chevron"></i>
            <div id="userMenuPanel" class="user-menu-panel">
                <div class="user-menu-header">
                    <div class="user-menu-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        <strong>{{ auth()->user()->name }}</strong>
                        <small>{{ auth()->user()->email }}</small>
                    </div>
                </div>
                <div class="user-menu-body">
                    <a href="{{ route('user.settings.edit') }}" class="user-menu-item">
                        <i class="fas fa-user-cog"></i> Mon compte
                    </a>
                    <div class="user-menu-divider"></div>
                    <a href="#" class="user-menu-item danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>

    </div>
</header>

<!-- CONTENU PRINCIPAL -->
<main class="main-content">
    @yield('content')
</main>

@stack('scripts')

<!-- Modal de confirmation global -->
@include('components.confirm-modal')

<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    /* ===== SIDEBAR ===== */
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('show');
        }
    });

    /* ===== NOTIFICATIONS ===== */
    function toggleNotifications(e) {
        e.stopPropagation();
        var notif = document.getElementById('notifPanel');
        var user  = document.getElementById('userMenuPanel');
        user.style.display = 'none';
        document.getElementById('userMenuTrigger').classList.remove('open');
        notif.style.display = notif.style.display === 'none' ? 'block' : 'none';
    }

    /* ===== USER MENU ===== */
    function toggleUserMenu(e) {
        e.stopPropagation();
        var user  = document.getElementById('userMenuPanel');
        var notif = document.getElementById('notifPanel');
        notif.style.display = 'none';
        var isOpen = user.style.display === 'block';
        user.style.display = isOpen ? 'none' : 'block';
        document.getElementById('userMenuTrigger').classList.toggle('open', !isOpen);
    }

    /* Fermer tout si clic dehors */
    document.addEventListener('click', function() {
        document.getElementById('notifPanel').style.display  = 'none';
        document.getElementById('userMenuPanel').style.display = 'none';
        document.getElementById('userMenuTrigger').classList.remove('open');
    });

    /* ===== RECHERCHE EMPLOYÉ ===== */
    document.addEventListener('DOMContentLoaded', function() {
        var input = document.getElementById('employeeSearchInput');
        var resultsDiv = document.getElementById('employeeSearchResults');
        if (!input) return;
        var timer;
        input.addEventListener('input', function() {
            clearTimeout(timer);
            var q = this.value.trim();
            if (q.length < 2) { resultsDiv.style.display = 'none'; return; }
            timer = setTimeout(function() {
                fetch('/admin/employees/search?query=' + encodeURIComponent(q))
                    .then(function(r) { return r.json(); })
                    .then(function(employees) {
                        if (employees.length === 0) {
                            resultsDiv.innerHTML = '<div style="padding:14px;color:var(--gray-600);font-size:13px;">Aucun employé trouvé.</div>';
                        } else {
                            resultsDiv.innerHTML = employees.map(function(emp) {
                                return '<a href="/admin/employees/' + emp.id + '" style="display:flex;align-items:center;gap:12px;padding:10px 14px;text-decoration:none;color:var(--dark);border-bottom:1px solid var(--gray-100);">'
                                    + '<div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#FF6200,#FF8C42);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;">' + emp.name.charAt(0).toUpperCase() + '</div>'
                                    + '<div><div style="font-weight:600;font-size:13px;">' + emp.name + '</div>'
                                    + '<div style="font-size:11px;color:var(--text-muted);">' + (emp.position || 'Sans poste') + ' · ' + (emp.department || '—') + '</div></div></a>';
                            }).join('');
                        }
                        resultsDiv.style.display = 'block';
                    });
            }, 300);
        });
        document.addEventListener('click', function(e) {
            if (input && !input.contains(e.target) && resultsDiv && !resultsDiv.contains(e.target)) {
                resultsDiv.style.display = 'none';
            }
        });
    });

    /* ===== MODAL CONFIRMATION ===== */
    function openConfirmModal(url) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('confirmModal').style.display = 'flex';
    }
    document.addEventListener('DOMContentLoaded', function() {
        var modal   = document.getElementById('confirmModal');
        var cancel  = document.getElementById('modalCancel');
        var confirm = document.getElementById('modalConfirm');
        if (cancel)  cancel.addEventListener('click',  function() { modal.style.display = 'none'; });
        if (confirm) confirm.addEventListener('click', function() { document.getElementById('deleteForm').submit(); });
        if (modal)   modal.addEventListener('click',   function(e) { if (e.target === this) this.style.display = 'none'; });
    });
</script>

</body>
</html>