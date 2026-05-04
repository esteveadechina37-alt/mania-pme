@extends('layouts.public')
@section('title', 'Connexion — Mania-PME')
@section('description', 'Connectez-vous à votre espace Mania-PME et gérez vos RH facilement')
@section('bodyClass', 'page-login')

@section('content')
<div class="login-wrapper">
    <div class="login-container">

        <!-- Left Panel: Benefits -->
        <div class="login-left">
            <div class="left-orb left-orb-1"></div>
            <div class="left-orb left-orb-2"></div>
            <div class="left-orb left-orb-3"></div>
            <div class="left-grid"></div>

            <div class="login-left-content">
                <div class="left-logo-mark">
                    <!-- <div class="logo-mark-inner"><span>M</span></div> -->
                     <a href="{{ url('/') }}" class="navbar-logo" style="display:flex;align-items:center;gap:8px;text-decoration:none;">
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
    <!-- <div class="logo-text">
        <span class="mania">Mania</span><span class="pme">-PME</span>
    </div> -->
</a>
                </div>

                <div class="left-badge">
                    <span class="badge-dot"></span>
                    Retour sur votre espace
                </div>

                <h2>Bon retour<br><span class="h2-accent">parmi nous.</span></h2>
                <p class="tagline">Connectez-vous et reprenez le contrôle de vos ressources humaines.</p>

                <ul class="benefits-list">
                    <li class="benefit-item">
                        <div class="benefit-icon"><i class="fas fa-chart-line"></i></div>
                        <div class="benefit-text"><h4>Vision globale en temps réel</h4><p>Tableaux de bord dynamiques</p></div>
                    </li>
                    <li class="benefit-item">
                        <div class="benefit-icon"><i class="fas fa-clock"></i></div>
                        <div class="benefit-text"><h4>Accès 24/7</h4><p>Disponible sur tous vos appareils</p></div>
                    </li>
                    <li class="benefit-item">
                        <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="benefit-text"><h4>Connexion sécurisée</h4><p>2FA et chiffrement de bout en bout</p></div>
                    </li>
                </ul>

                <div class="left-stats">
                    <div class="left-stat"><div class="stat-val">500+</div><div class="stat-lbl">PME actives</div></div>
                    <div class="stat-sep"></div>
                    <div class="left-stat"><div class="stat-val">12k+</div><div class="stat-lbl">Employés gérés</div></div>
                    <div class="stat-sep"></div>
                    <div class="left-stat"><div class="stat-val">98%</div><div class="stat-lbl">Satisfaction</div></div>
                </div>

                <div class="testimonial">
                    <div class="testi-top">
                        <div class="testi-av">MK</div>
                        <div>
                            <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                            <p class="testimonial-author">Mamadou Koné — DG, Groupe Konex</p>
                        </div>
                    </div>
                    <p class="testimonial-text">"L'interface est bluffante de simplicité. En quelques secondes, j'accède à tous mes indicateurs RH."</p>
                </div>
            </div>
        </div>

        <!-- Right Panel: Login Form + Footer -->
        <div class="login-right">
            <div class="login-right-content">
                <div class="form-header">
                    <h1>Connexion</h1>
                    <p class="subtitle">Ravis de vous revoir. Entrez vos identifiants.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="session-status success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="session-status error">
                        <i class="fas fa-exclamation-circle"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label>Email professionnel <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" placeholder="jean@entreprise.com" value="{{ old('email') }}" required autofocus autocomplete="username">
                            <div class="input-border-anim"></div>
                        </div>
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label>Mot de passe <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" placeholder="Votre mot de passe" required autocomplete="current-password">
                            <div class="input-border-anim"></div>
                        </div>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="form-options">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="remember">
                            <span class="checkmark"></span>
                            <span class="check-text">Se souvenir de moi</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login">
                        <span class="btn-content"><i class="fas fa-arrow-right-to-bracket"></i> Se connecter</span>
                        <span class="btn-shine"></span>
                    </button>
                </form>
            </div>

            <!-- FOOTER - Dans login-right -->
            <div class="login-footer">
                <div class="form-divider footer-divider"><span>ou continuer avec</span></div>
                
                <div class="social-login footer-social">
                    <button type="button" class="social-btn-item" onclick="socialLogin('google')">
                        <svg width="16" height="16" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        Google
                    </button>
                    <button type="button" class="social-btn-item" onclick="socialLogin('linkedin')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#0A66C2"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        LinkedIn
                    </button>
                </div>

                <p class="register-link footer-register-link">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}">Créer mon compte <i class="fas fa-arrow-right"></i></a>
                </p>

                <div class="footer-copyright">
                    <p>&copy; {{ date('Y') }} Mania-PME. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ═══════════════════════════════════════
   PAGE LOGIN — MÊME DESIGN QUE REGISTER
═══════════════════════════════════════ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body.page-login {
    background: #F0EDE8;
    overflow-y: auto;
    overflow-x: hidden;
}

.login-wrapper {
    min-height: 100vh;
    background: #F0EDE8;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 72px 0 40px 0;
}

.login-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 380px 1fr;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    background: #fff;
}

/* ─── LEFT PANEL - SANS SCROLL HORIZONTAL ─── */
.login-left {
    background: #0A0A0A;
    padding: 28px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow-y: auto;
    overflow-x: hidden;
    max-height: 680px;
    width: 100%;
}

.login-left-content {
    position: relative;
    z-index: 2;
    width: 100%;
    overflow-x: hidden;
}

.left-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    pointer-events: none;
}
.left-orb-1 { width: 280px; height: 280px; background: rgba(255, 98, 0, 0.18); top: -80px; right: -80px; animation: orbFloat1 8s ease-in-out infinite; }
.left-orb-2 { width: 180px; height: 180px; background: rgba(255, 140, 66, 0.1); bottom: 40px; left: -60px; animation: orbFloat2 10s ease-in-out infinite; }
.left-orb-3 { width: 130px; height: 130px; background: rgba(255, 98, 0, 0.08); top: 50%; left: 50%; transform: translate(-50%, -50%); animation: orbFloat1 12s ease-in-out infinite reverse; }

@keyframes orbFloat1 { 0%, 100% { transform: translate(0, 0) scale(1); } 33% { transform: translate(-20px, 20px) scale(1.05); } 66% { transform: translate(15px, -15px) scale(0.95); } }
@keyframes orbFloat2 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(20px, -20px); } }

.left-grid {
    position: absolute;
    inset: 0;
    background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
    background-size: 32px 32px;
    pointer-events: none;
}

.left-logo-mark {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #FF6200, #FF8C42);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}
.logo-mark-inner { font-family: 'Clash Display', sans-serif; font-size: 20px; font-weight: 700; color: #fff; }

.left-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 98, 0, 0.12);
    border: 1px solid rgba(255, 98, 0, 0.25);
    color: #FF8C42;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 100px;
    margin-bottom: 16px;
}
.badge-dot { width: 5px; height: 5px; border-radius: 50%; background: #FF6200; animation: pulseDot 1.5s ease infinite; }
@keyframes pulseDot { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(0.7); } }

.login-left h2 {
    font-family: 'Clash Display', sans-serif;
    font-size: 26px;
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
    letter-spacing: -0.8px;
    margin-bottom: 8px;
}
.h2-accent { color: #FF6200; display: block; }

.tagline {
    color: rgba(255, 255, 255, 0.45);
    font-size: 12px;
    line-height: 1.4;
    margin-bottom: 20px;
}

.benefits-list {
    list-style: none;
    margin-bottom: 18px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.benefit-item {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 10px;
    width: 100%;
}
.benefit-icon {
    width: 28px;
    height: 28px;
    background: rgba(255, 98, 0, 0.12);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.benefit-icon i { color: #FF6200; font-size: 12px; }
.benefit-text h4 { font-size: 11px; font-weight: 700; color: #fff; margin-bottom: 2px; }
.benefit-text p { font-size: 9px; color: rgba(255, 255, 255, 0.4); line-height: 1.3; }

.left-stats {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-top: 1px solid rgba(255, 255, 255, 0.07);
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    margin-bottom: 14px;
    width: 100%;
}
.stat-val { font-family: 'Clash Display', sans-serif; font-size: 16px; font-weight: 700; color: #FF6200; text-align: center; }
.stat-lbl { font-size: 8px; color: rgba(255, 255, 255, 0.3); margin-top: 2px; text-transform: uppercase; }
.stat-sep { width: 1px; height: 20px; background: rgba(255, 255, 255, 0.08); }

.testimonial {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 10px 12px;
    width: 100%;
}
.testi-top { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
.testi-av {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, #FF6200, #FF8C42);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}
.testimonial-stars i { color: #FF6200; font-size: 8px; }
.testimonial-author { font-size: 9px; color: rgba(255, 255, 255, 0.5); }
.testimonial-text { font-size: 10px; font-style: italic; color: rgba(255, 255, 255, 0.65); line-height: 1.4; }

/* ─── RIGHT PANEL LOGIN + FOOTER ─── */
.login-right {
    background: #fff;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    max-height: 680px;
}

.login-right-content {
    padding: 32px 32px 16px;
    flex-shrink: 0;
}

.form-header { margin-bottom: 20px; }
.form-header h1 {
    font-family: 'Clash Display', sans-serif;
    font-size: 26px;
    font-weight: 700;
    color: #0A0A0A;
    margin-bottom: 4px;
}
.subtitle { color: #999; font-size: 13px; }

/* Session status messages */
.session-status {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 20px;
}
.session-status.success {
    background: rgba(255, 98, 0, 0.1);
    color: #FF6200;
    border: 1px solid rgba(255, 98, 0, 0.2);
}
.session-status.error {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border: 1px solid rgba(220, 53, 69, 0.2);
}
.session-status i { font-size: 14px; }

.form-group { margin-bottom: 16px; }
label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}
.required { color: #FF6200; }

.input-wrapper { position: relative; }
.input-border-anim {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: #FF6200;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s;
}
.input-wrapper:focus-within .input-border-anim { transform: scaleX(1); }

.input-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #ccc;
    font-size: 13px;
    pointer-events: none;
    transition: color 0.2s;
}
.input-wrapper:focus-within .input-icon { color: #FF6200; }

input {
    width: 100%;
    padding: 11px 12px 11px 38px;
    border: 1.5px solid #ebebeb;
    border-radius: 10px;
    font-size: 13px;
    font-family: inherit;
    color: #0A0A0A;
    background: #fafafa;
    transition: all 0.2s;
    outline: none;
}
input:focus {
    border-color: rgba(255, 98, 0, 0.3);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(255, 98, 0, 0.06);
}

.form-error {
    display: block;
    font-size: 11px;
    color: #dc3545;
    margin-top: 5px;
}

/* Form options */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.custom-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}
.custom-checkbox input[type="checkbox"] { display: none; }
.checkmark {
    width: 17px;
    height: 17px;
    border: 2px solid #e0e0e0;
    border-radius: 4px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.custom-checkbox input:checked ~ .checkmark {
    background: #FF6200;
    border-color: #FF6200;
}
.custom-checkbox input:checked ~ .checkmark::after {
    content: '';
    width: 8px;
    height: 4px;
    border-left: 2px solid #fff;
    border-bottom: 2px solid #fff;
    transform: rotate(-45deg) translate(1px, -1px);
}
.check-text {
    font-size: 12px;
    color: #666;
}

.forgot-link {
    font-size: 12px;
    color: #FF6200;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}
.forgot-link:hover {
    color: #e05500;
    text-decoration: underline;
}

/* Login Button */
.btn-login {
    width: 100%;
    height: 48px;
    background: linear-gradient(135deg, #FF6200, #FF8C42);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-family: 'Clash Display', sans-serif;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.2s;
}
.btn-login:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(255, 98, 0, 0.3);
}
.btn-content { display: flex; align-items: center; justify-content: center; gap: 8px; position: relative; z-index: 1; }
.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 60%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transform: skewX(-20deg);
    animation: btnShine 3s ease-in-out infinite;
}
@keyframes btnShine { 0% { left: -100%; } 40% { left: 150%; } 100% { left: 150%; } }

/* ─── FOOTER DANS LOGIN-RIGHT ─── */
.login-footer {
    padding: 16px 32px 24px;
    border-top: 1px solid #f0f0f0;
    background: #fff;
    margin-top: auto;
    flex-shrink: 0;
}

.footer-divider {
    margin: 0 0 16px 0;
}
.footer-divider::before,
.footer-divider::after {
    background: #e0e0e0;
}
.footer-divider span {
    color: #aaa;
    font-size: 12px;
}

.footer-social {
    margin-bottom: 16px;
}
.footer-social .social-btn-item {
    background: #fafafa;
    border-color: #e0e0e0;
}
.footer-social .social-btn-item:hover {
    background: #fff;
    border-color: #FF6200;
}

.footer-register-link {
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0f0f0;
}

.footer-copyright {
    text-align: center;
}
.footer-copyright p {
    font-size: 11px;
    color: #aaa;
    letter-spacing: 0.3px;
}

.social-login {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.social-btn-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 16px;
    border: 1.5px solid #ebebeb;
    border-radius: 10px;
    background: #fff;
    font-size: 13px;
    font-weight: 600;
    color: #333;
    cursor: pointer;
    transition: all 0.2s;
}
.social-btn-item:hover {
    border-color: #FF6200;
    background: rgba(255, 98, 0, 0.03);
}

.register-link {
    text-align: center;
    font-size: 13px;
    color: #999;
}
.register-link a {
    color: #FF6200;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.register-link a:hover { gap: 8px; }

/* Scrollbars */
.login-left::-webkit-scrollbar,
.login-right::-webkit-scrollbar {
    width: 4px;
}
.login-left::-webkit-scrollbar-track { background: #1a1a1a; }
.login-left::-webkit-scrollbar-thumb { background: #FF6200; border-radius: 4px; }
.login-right::-webkit-scrollbar-track { background: #f0f0f0; }
.login-right::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }

/* Responsive */
@media (max-width: 950px) {
    .login-container { grid-template-columns: 320px 1fr; margin: 0 16px; }
}
@media (max-width: 800px) {
    .login-container { grid-template-columns: 1fr; margin: 0 16px; border-radius: 20px; }
    .login-left { display: none; }
    .login-right { max-height: none; }
}
@media (max-width: 550px) {
    .login-right-content { padding: 24px 20px 16px; }
    .login-footer { padding: 16px 20px 20px; }
    .form-options { flex-direction: column; gap: 12px; align-items: flex-start; }
    .social-login { grid-template-columns: 1fr; }
}
</style>
@endpush

@push('scripts')
<script>
    function socialLogin(provider) {
        showNotification(`Connexion avec ${provider} - Fonctionnalité à venir`, 'info');
    }

    function showNotification(message, type) {
        const notif = document.createElement('div');
        const bgColor = type === 'success' ? '#FF6200' : (type === 'error' ? '#dc3545' : '#17a2b8');
        notif.style.cssText = `
            position:fixed; top:90px; right:24px; z-index:9999;
            background:${bgColor}; color:#fff; padding:12px 20px; border-radius:10px;
            font-weight:600; font-size:13px; box-shadow:0 8px 24px rgba(0,0,0,0.2);
            animation:slideInNotif 0.3s ease both; display:flex; align-items:center; gap:8px;
            z-index:10000;
        `;
        notif.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : (type === 'error' ? 'exclamation-circle' : 'info-circle')}"></i>${message}`;
        document.body.appendChild(notif);
        setTimeout(() => {
            notif.style.opacity = '0';
            notif.style.transform = 'translateX(30px)';
            notif.style.transition = '0.3s';
            setTimeout(() => notif.remove(), 300);
        }, 4000);
    }

    // Auto-hide session status messages
    document.addEventListener('DOMContentLoaded', () => {
        const statusMessages = document.querySelectorAll('.session-status');
        statusMessages.forEach(msg => {
            setTimeout(() => {
                msg.style.opacity = '0';
                msg.style.transform = 'translateY(-10px)';
                msg.style.transition = '0.3s';
                setTimeout(() => msg.remove(), 300);
            }, 5000);
        });
    });
</script>
@endpush