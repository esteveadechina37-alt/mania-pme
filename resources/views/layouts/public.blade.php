<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'La plateforme RH pour les PME africaines.')">
    <meta property="og:title" content="@yield('title', 'Mania-PME')">
    <meta property="og:description" content="@yield('description', 'Gérez vos RH sans friction.')">
    <meta property="og:type" content="website">
    <title>@yield('title', 'Mania-PME — Gérez vos RH sans friction')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
          integrity="sha512-Kc323vGkJpeuLDoW+OMB1OPmvCew06pC34l7bSloqsmgFQboZm78OcB+zIkIUKSD0hNZcWn/non7T4FUkC7ZwQ==" 
          crossorigin="anonymous" referrerpolicy="no-referrer">

    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css"
          media="print" onload="this.media='all'">

    <noscript>
        <link rel="stylesheet" 
              href="https://unpkg.com/@fortawesome/fontawesome-free@6.6.0/css/all.min.css">
    </noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --orange: #FF6200;
            --orange2: #FF8C42;
            --black: #0A0A0A;
            --white: #FFFFFF;
            --gray: #F7F4F0;
            --muted: #6B6B6B;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            font-family: 'Cabinet Grotesk', sans-serif;
            color: var(--black);
            background-color: var(--white);
            overflow-x: hidden;
        }
        body.overflow-hidden { overflow: hidden; }

        .fas, .far, .fab, .fa, .fa-solid, .fa-regular, .fa-brands {
            display: inline-block !important;
            font-style: normal !important;
            font-variant: normal !important;
            text-rendering: auto !important;
            -webkit-font-smoothing: antialiased !important;
            line-height: 1 !important;
        }

        h1, h2, h3, h4, h5, h6, .cd {
            font-family: 'Clash Display', sans-serif;
            font-weight: 700;
        }
        a { color: inherit; text-decoration: none; }

        /* Animations (inchangées, je les garde pour la continuité) */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
        @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(0.8); } }
        @keyframes glow { 0%, 100% { opacity: 0.6; } 50% { opacity: 1; } }
        @keyframes slideInBurger { from { transform: translateX(100%); } to { transform: translateX(0); } }
        @keyframes slideOutBurger { from { transform: translateX(0); } to { transform: translateX(100%); } }
        @keyframes menuItemSlide { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }

        .reveal {
            opacity: 0; transform: translateY(24px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.12s; }
        .reveal-delay-2 { transition-delay: 0.24s; }
        .reveal-delay-3 { transition-delay: 0.36s; }

        /* Navbar */
        nav.navbar {
            position: fixed; top: 0; left: 0; right: 0; height: 72px;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(0,0,0,0.06); z-index: 1000;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 5%; transition: box-shadow 0.3s ease;
        }
        nav.navbar.shadow { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }

        .navbar-logo {
            font-family: 'Clash Display', sans-serif; font-size: 20px; font-weight: 700;
            display: flex; align-items: center; gap: 8px;
        }
        .navbar-logo .dot {
            width: 8px; height: 8px; background: var(--orange); border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }
        .navbar-logo .logo-text { display: flex; align-items: center; }
        .navbar-logo .mania { color: var(--black); }
        .navbar-logo .pme { color: var(--orange); }

        .nav-links {
            display: flex; align-items: center; gap: 40px; flex: 1; justify-content: center;
        }
        .nav-link {
            position: relative; color: var(--black); font-size: 14px; font-weight: 500;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px;
            background: var(--orange); transition: width 0.35s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .nav-link:hover::after { width: 100%; }
        .nav-link.active { color: var(--orange); }
        .nav-link.active::after { width: 100%; }

        /* Container for desktop CTA + login */
        .navbar-actions {
            display: flex; align-items: center; gap: 12px;
        }
        .navbar-login {
            width: 40px; height: 40px; border-radius: 50%;
            border: 1px solid rgba(0,0,0,0.1); background: transparent;
            display: flex; align-items: center; justify-content: center;
            color: var(--black); transition: all 0.3s ease; font-size: 14px;
        }
        .navbar-login:hover {
            border-color: var(--orange); color: var(--orange);
            background: rgba(255,98,0,0.05);
        }
        .navbar-cta {
            background: var(--orange); color: var(--white); padding: 10px 24px;
            border-radius: 100px; font-size: 13px; font-weight: 600;
            display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;
            white-space: nowrap;
        }
        .navbar-cta:hover { background: #FF7722; transform: translateY(-2px); }

        /* Login icon specifically for mobile (hidden on desktop) */
        .mobile-login {
            display: none; /* hidden by default, shown on mobile */
            width: 40px; height: 40px; border-radius: 50%;
            border: 1px solid rgba(0,0,0,0.1); background: transparent;
            align-items: center; justify-content: center;
            color: var(--black); transition: all 0.3s ease; font-size: 14px;
            margin-right: 12px; /* space between login icon and burger */
        }
        .mobile-login:hover {
            border-color: var(--orange); color: var(--orange);
            background: rgba(255,98,0,0.05);
        }

        /* Burger */
        .burger {
            display: none; flex-direction: column; cursor: pointer;
            width: 32px; height: 32px; justify-content: center; align-items: center;
            z-index: 1001;
        }
        .burger-bar {
            width: 24px; height: 2px; background: var(--black);
            transition: all 0.35s cubic-bezier(0.23, 1, 0.32, 1);
            transform-origin: center;
        }
        .burger-bar:nth-child(1) { margin-bottom: 5px; }
        .burger-bar:nth-child(2) { margin-bottom: 5px; }
        .burger.active .burger-bar:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .burger.active .burger-bar:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .burger.active .burger-bar:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* Desktop : masquer le conteneur mobile */
        .mobile-actions {
            display: none;
        }

        /* Mobile : afficher le conteneur avec peu d'espace */
        @media (max-width: 900px) {
            .mobile-actions {
                display: flex;
                align-items: center;
                gap: 6px; /* ↕️ valeur idéale, tu peux mettre 4px, 8px... */
            }

            .mobile-login {
                margin-right: 0; /* plus besoin */
            }

            /* Le burger reste tel quel */
        }

        /* Mobile Menu (unchanged) */
        .mobile-menu {
            position: fixed; inset: 0; background: var(--black); z-index: 999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transform: translateX(100%); transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .mobile-menu.active { transform: translateX(0); }
        .mobile-menu::before {
            content: ''; position: absolute; width: 400px; height: 400px;
            border: 2px solid rgba(255,98,0,0.08); border-radius: 50%;
            top: -150px; right: -150px;
        }
        .mobile-menu::after {
            content: ''; position: absolute; width: 300px; height: 300px;
            background: rgba(255,98,0,0.03); border-radius: 50%;
            bottom: -100px; left: -100px;
        }
        .mobile-menu-logo {
            position: absolute; top: 24px; left: 5%;
            font-family: 'Clash Display', sans-serif; font-size: 18px; font-weight: 700;
            color: var(--white); display: flex; align-items: center; gap: 6px;
        }
        .mobile-menu-logo .dot {
            width: 6px; height: 6px; background: var(--orange); border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }
        .mobile-menu-links {
            display: flex; flex-direction: column; gap: 32px; position: relative; z-index: 2;
        }
        .mobile-menu-link {
            font-family: 'Clash Display', sans-serif; font-size: 36px; font-weight: 700;
            color: rgba(255,255,255,0.6); display: flex; align-items: center; gap: 16px;
            transition: color 0.3s ease; opacity: 0;
            animation: menuItemSlide 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .mobile-menu-link:nth-child(1) { animation-delay: 0.08s; }
        .mobile-menu-link:nth-child(2) { animation-delay: 0.14s; }
        .mobile-menu-link:nth-child(3) { animation-delay: 0.20s; }
        .mobile-menu-link:nth-child(4) { animation-delay: 0.26s; }
        .mobile-menu.active .mobile-menu-link {
            animation: menuItemSlide 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .mobile-menu-link:hover { color: var(--orange); }
        .mobile-menu-link i { font-size: 32px; transition: transform 0.3s ease; }
        .mobile-menu-link:hover i { transform: scale(1.1); }

        .mobile-menu-cta {
            margin-top: 48px; position: relative; z-index: 2;
            background: var(--orange); color: var(--white); padding: 14px 32px;
            border-radius: 100px; font-size: 14px; font-weight: 600;
            display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;
            animation: menuItemSlide 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.32s forwards;
            opacity: 0;
        }
        .mobile-menu.active .mobile-menu-cta {
            animation: menuItemSlide 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.32s forwards;
        }
        .mobile-menu-cta:hover { background: #FF7722; transform: translateY(-2px); }
        .mobile-menu .deco-line {
            position: absolute; bottom: 40px; left: 5%; right: 5%; height: 3px;
            background: linear-gradient(90deg, var(--orange) 0%, transparent 100%); z-index: 2;
        }

        main {
            min-height: calc(100vh - 72px);
            display: flex; flex-direction: column;
        }

        /* Footer (identique à l'original, mais je le laisse pour intégrité) */
        footer {
            background: var(--black); color: var(--white); padding: 80px 5% 40px; margin-top: auto;
        }
        .footer-grid {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 56px; margin-bottom: 56px;
        }
        .footer-brand h3 {
            font-family: 'Clash Display', sans-serif; font-size: 20px; margin-bottom: 16px;
        }
        .footer-brand p {
            color: rgba(255,255,255,0.7); font-size: 14px; line-height: 1.6; margin-bottom: 24px;
        }
        .footer-newsletter {
            display: flex; gap: 8px; margin-bottom: 24px;
        }
        .footer-newsletter input {
            flex: 1; padding: 10px 14px; border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.05); color: var(--white); border-radius: 6px; font-size: 13px;
        }
        .footer-newsletter input::placeholder { color: rgba(255,255,255,0.5); }
        .footer-newsletter input:focus {
            outline: none; border-color: var(--orange); background: rgba(255,255,255,0.08);
        }
        .footer-newsletter button {
            background: var(--orange); color: var(--white); border: none;
            padding: 10px 16px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer;
        }
        .footer-newsletter button:hover { background: #FF7722; transform: translateY(-2px); }
        .footer-socials { display: flex; gap: 12px; }
        .footer-social-link {
            width: 36px; height: 36px; border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.6); transition: all 0.3s ease; font-size: 14px;
        }
        .footer-social-link:hover {
            border-color: var(--orange); color: var(--orange); background: rgba(255,98,0,0.1);
        }
        .footer-column h4 {
            font-family: 'Clash Display', sans-serif; font-size: 14px; margin-bottom: 20px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .footer-column ul { list-style: none; }
        .footer-column ul li { margin-bottom: 12px; }
        .footer-column ul li a {
            color: rgba(255,255,255,0.6); font-size: 14px; transition: color 0.3s ease;
        }
        .footer-column ul li a:hover { color: var(--orange); }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.07); padding-top: 32px;
            display: grid; grid-template-columns: 1fr auto auto; gap: 32px; align-items: center;
            font-size: 13px; color: rgba(255,255,255,0.6);
        }
        .footer-copyright { color: rgba(255,255,255,0.5); }
        .footer-languages { display: flex; gap: 16px; align-items: center; }
        .footer-languages a { color: rgba(255,255,255,0.6); transition: color 0.3s ease; }
        .footer-languages a:hover { color: var(--orange); }
        .footer-legal { display: flex; gap: 16px; align-items: center; justify-self: end; }
        .footer-legal a { color: rgba(255,255,255,0.6); transition: color 0.3s ease; }
        .footer-legal a:hover { color: var(--orange); }
        .footer-africa {
            text-align: center; font-size: 12px; color: rgba(255,255,255,0.5);
            margin-top: 24px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.07);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .nav-links, .navbar-actions {
                display: none; /* hide desktop nav links and CTA */
            }

            /* Show the mobile login icon */
            .mobile-login {
                display: flex;
            }

            .burger {
                display: flex;
            }

            .navbar-logo {
                margin-left: 0; /* ensure left aligned */
            }

            .footer-grid {
                grid-template-columns: 1fr; gap: 48px;
            }
            .footer-bottom {
                grid-template-columns: 1fr; gap: 16px;
            }
            .footer-legal {
                justify-self: auto;
            }
        }

        @media (max-width: 600px) {
            .navbar-logo { font-size: 16px; }
            .mobile-menu-link { font-size: 28px; }
            .mobile-menu-logo { font-size: 14px; }
            footer { padding: 48px 5% 24px; }
            .footer-grid { gap: 32px; }
            .footer-bottom { font-size: 12px; }
        }
    </style>

    @stack('styles')
</head>
<body class="@yield('bodyClass', '')">

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="{{ url('/') }}" class="navbar-logo">
            <svg width="32" height="32" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="logoGradNav" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#FF6200"/>
                        <stop offset="100%" style="stop-color:#FF8C42"/>
                    </linearGradient>
                </defs>
                <rect width="38" height="38" rx="9" fill="url(#logoGradNav)"/>
                <path d="M8 25V12L18 19.5L28 12V25"
                    stroke="white" stroke-width="2.6"
                    stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <circle cx="28" cy="25" r="2.2" fill="white" fill-opacity="0.9"/>
                <line x1="9" y1="25" x2="17.5" y2="25" stroke="white" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
            </svg>
            <div class="logo-text">
                <span class="mania">Mania</span><span class="pme">-PME</span>
            </div>
        </a>

        <div class="nav-links">
            <a href="{{ url('/fonctionnalites') }}" class="nav-link @if(request()->is('fonctionnalites')) active @endif">
                Fonctionnalités
            </a>
            <a href="{{ url('/tarifs') }}" class="nav-link @if(request()->is('tarifs')) active @endif">
                Tarifs
            </a>
            <a href="{{ url('/a-propos') }}" class="nav-link @if(request()->is('a-propos')) active @endif">
                À propos
            </a>
            <a href="{{ url('/contact') }}" class="nav-link @if(request()->is('contact')) active @endif">
                Contact
            </a>
        </div>

        <!-- Desktop actions (hidden on mobile) -->
        <div class="navbar-actions">
            <a href="{{ route('login') }}" class="navbar-login" title="Se connecter">
                <i class="fas fa-user"></i>
            </a>
            <a href="@auth{{ route('admin.dashboard') }}@else{{ route('register') }}@endauth" class="navbar-cta">
                @auth
                    <span>Mon espace</span>
                    <i class="fas fa-arrow-right"></i>
                @else
                    <span>Démarrer gratuitement</span>
                @endauth
            </a>
        </div>

        <!-- Mobile login icon (visible only on mobile) -->
        <div class="mobile-actions">
        <a href="{{ route('login') }}" class="mobile-login" title="Se connecter">
            <i class="fas fa-user"></i>
        </a>

        <div class="burger" id="burgerMenu" onclick="toggleMenu()">
            <div class="burger-bar"></div>
            <div class="burger-bar"></div>
            <div class="burger-bar"></div>
        </div>
        </div>
    </nav>

    <!-- MOBILE MENU (inchangé) -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-logo">
            <div class="dot"></div>
            <div>Mania<span style="color: var(--orange);">-PME</span></div>
        </div>
        <div class="mobile-menu-links">
            <a href="{{ url('/fonctionnalites') }}" class="mobile-menu-link" onclick="closeMenu()">
                <i class="fas fa-th-large"></i>
                <span>Fonctionnalités</span>
            </a>
            <a href="{{ url('/tarifs') }}" class="mobile-menu-link" onclick="closeMenu()">
                <i class="fas fa-tags"></i>
                <span>Tarifs</span>
            </a>
            <a href="{{ url('/a-propos') }}" class="mobile-menu-link" onclick="closeMenu()">
                <i class="fas fa-info-circle"></i>
                <span>À propos</span>
            </a>
            <a href="{{ url('/contact') }}" class="mobile-menu-link" onclick="closeMenu()">
                <i class="fas fa-envelope"></i>
                <span>Contact</span>
            </a>
        </div>
        <a href="@auth{{ route('admin.dashboard') }}@else{{ route('register') }}@endauth" class="mobile-menu-cta" onclick="closeMenu()">
            <i class="fas fa-rocket"></i>
            <span>@auth Mon espace @else Démarrer @endauth</span>
        </a>
        <div class="deco-line"></div>
    </div>

    <main style="padding-top: 72px;">
        @yield('content')
    </main>

    <!-- FOOTER (identique à l’original, logo avec dégradé footer) -->
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ url('/') }}" style="display:flex;align-items:center;gap:8px;text-decoration:none;">
                    <svg width="32" height="32" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="logoGradFooter" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#FF6200"/>
                                <stop offset="100%" style="stop-color:#FF8C42"/>
                            </linearGradient>
                        </defs>
                        <rect width="38" height="38" rx="9" fill="url(#logoGradFooter)"/>
                        <path d="M8 25V12L18 19.5L28 12V25" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <circle cx="28" cy="25" r="2.2" fill="white" fill-opacity="0.9"/>
                        <line x1="9" y1="25" x2="17.5" y2="25" stroke="white" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
                    </svg>
                    <div style="font-family:'Clash Display',sans-serif;font-size:20px;font-weight:700;color:white;">
                        Mania<span style="color:#FF6200;">-PME</span>
                    </div>
                </a>
                <p>La plateforme RH pensée pour les PME africaines.</p>
                <div class="footer-newsletter">
                    <input type="email" placeholder="Votre email" id="footerEmail">
                    <button onclick="subscribeNewsletter()">S'abonner</button>
                </div>
                <div class="footer-socials">
                    <a href="#" class="footer-social-link"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="footer-social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="footer-social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="footer-social-link"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="footer-social-link"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <!-- Produit Column -->
            <div class="footer-column">
                <h4>Produit</h4>
                <ul>
                    <li><a href="{{ url('/fonctionnalites') }}">Fonctionnalités</a></li>
                    <li><a href="{{ url('/tarifs') }}">Tarifs</a></li>
                    <li><a href="#">Mises à jour</a></li>
                    <li><a href="#">Roadmap</a></li>
                    <li><a href="#">Statut</a></li>
                </ul>
            </div>

            <!-- Entreprise Column -->
            <div class="footer-column">
                <h4>Entreprise</h4>
                <ul>
                    <li><a href="{{ url('/a-propos') }}">À propos</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Carrières</a></li>
                    <li><a href="#">Partenaires</a></li>
                    <li><a href="#">Presse</a></li>
                </ul>
            </div>

            <!-- Support Column -->
            <div class="footer-column">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Centre d'aide</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Formation</a></li>
                    <li><a href="#">API</a></li>
                </ul>
            </div>

            <!-- Légal Column -->
            <div class="footer-column">
                <h4>Légal</h4>
                <ul>
                    <li><a href="#">Confidentialité</a></li>
                    <li><a href="#">CGU</a></li>
                    <li><a href="#">Cookies</a></li>
                    <li><a href="#">RGPD</a></li>
                    <li><a href="#">Mentions légales</a></li>
                </ul>
            </div>
        </div>

        </div>
        <div class="footer-bottom">
            <div class="footer-copyright">© {{ date('Y') }} Mania-PME. Tous droits réservés.</div>
            <div class="footer-languages">
                <a href="#">Français</a>
                <span>|</span>
                <a href="#">English</a>
                <span>|</span>
                <a href="#">Português</a>
            </div>
            <div class="footer-legal">
                <a href="#">Confidentialité</a>
                <span>·</span>
                <a href="#">CGU</a>
                <span>·</span>
                <a href="#">Cookies</a>
            </div>
        </div>
        <div class="footer-africa">
            Conçu avec passion ♥ en Afrique · Mania-PME {{ date('Y') }}
        </div>
    </footer>

    <script>
        // Toggle Mobile Menu
        function toggleMenu() {
            const burger = document.getElementById('burgerMenu');
            const menu = document.getElementById('mobileMenu');
            burger.classList.toggle('active');
            menu.classList.toggle('active');
            document.body.classList.toggle('overflow-hidden', menu.classList.contains('active'));
        }
        function closeMenu() {
            const burger = document.getElementById('burgerMenu');
            const menu = document.getElementById('mobileMenu');
            burger.classList.remove('active');
            menu.classList.remove('active');
            document.body.classList.remove('overflow-hidden');
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeMenu();
        });
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav.navbar');
            if (window.scrollY > 10) navbar.classList.add('shadow');
            else navbar.classList.remove('shadow');
        });
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); } });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        function subscribeNewsletter() {
            const email = document.getElementById('footerEmail').value;
            if (!email) return alert('Veuillez entrer votre email');
            alert('Merci de votre inscription! 🎉');
            document.getElementById('footerEmail').value = '';
        }
    </script>

    @stack('scripts')
</body>
</html>