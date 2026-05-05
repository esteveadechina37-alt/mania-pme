@extends('layouts.public')
@section('title', 'Créer mon espace — Mania-PME')
@section('description', 'Inscrivez-vous à Mania-PME et commencez à gérer vos RH facilement')
@section('bodyClass', 'page-register')

@section('content')
<div class="register-wrapper">
    <div class="register-container">

        <!-- Left Panel: Benefits -->
        <div class="register-left">
            <div class="left-orb left-orb-1"></div>
            <div class="left-orb left-orb-2"></div>
            <div class="left-orb left-orb-3"></div>
            <div class="left-grid"></div>

            <div class="register-left-content">
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
                    Plateforme RH #1 en Afrique
                </div>

                <h2>Votre espace RH<br><span class="h2-accent">en 2 minutes.</span></h2>
                <p class="tagline">La solution intelligente pensée pour les PME africaines.</p>

                <ul class="benefits-list">
                    <li class="benefit-item">
                        <div class="benefit-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="benefit-text"><h4>Démarrage 100% gratuit</h4><p>14 jours d'essai, sans carte</p></div>
                    </li>
                    <li class="benefit-item">
                        <div class="benefit-icon"><i class="fas fa-bolt"></i></div>
                        <div class="benefit-text"><h4>Simple à utiliser</h4><p>Interface intuitive sans formation</p></div>
                    </li>
                    <li class="benefit-item">
                        <div class="benefit-icon"><i class="fas fa-headset"></i></div>
                        <div class="benefit-text"><h4>Support francophone 24/7</h4><p>Une équipe toujours disponible</p></div>
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
                        <div class="testi-av">FK</div>
                        <div>
                            <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                            <p class="testimonial-author">Fatima Kane — PDG, TechAfrica</p>
                        </div>
                    </div>
                    <p class="testimonial-text">"Mania-PME a transformé notre gestion RH."</p>
                </div>
            </div>
        </div>

        <!-- Right Panel: Carousel Form + Footer -->
        <div class="register-right">
            <!-- Step indicator -->
            <div class="form-progress">
                <div class="progress-step" data-step="1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Compte</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step" data-step="2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Entreprise</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step" data-step="3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Localisation</div>
                </div>
            </div>

            <div class="register-right-content">
                <div class="form-header">
                    <h1 id="stepTitle">Créer mon compte</h1>
                    <p id="stepSubtitle" class="subtitle">Commencez par vos informations personnelles</p>

                    <!-- voir les erreurs si des champs manquent ou sont mal remplis -->

                    @if($errors->any())
    <div style="background:rgba(220,38,38,0.08); border:1px solid rgba(220,38,38,0.2); border-radius:10px; padding:14px 18px; margin-bottom:20px;">
        <p style="font-size:13px; font-weight:700; color:#dc2626; margin-bottom:8px;">
            <i class="fas fa-exclamation-triangle"></i> Veuillez corriger les erreurs suivantes :
        </p>
        <ul style="list-style:none; display:flex; flex-direction:column; gap:4px;">
            @foreach($errors->all() as $error)
                <li style="font-size:12.5px; color:#dc2626;">• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                </div>

                <!-- <form id="registerForm" onsubmit="handleFinalSubmit(event)"> -->
                    <form id="registerForm" method="POST" action="{{ route('register') }}"> 
                        @csrf
                    <!-- Step 1: Personal Info -->
                    <div id="step1" class="form-step active">
                        <div class="form-group">
                            <label>Nom complet <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" id="full_name" name="name" placeholder="nom complet" required>
                                <div class="input-border-anim"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email personnel <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" id="personal_email" name="email" placeholder="jean@example.com" required>
                                <div class="input-border-anim"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Mot de passe <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" id="password" name="password" placeholder="Min. 8 caractères" required minlength="8">
                                    <div class="input-border-anim"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Confirmer <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" id="password_confirm" placeholder="Confirmer" required minlength="8" name="password_confirmation">
                                    <div class="input-border-anim"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Company Info -->
                    <div id="step2" class="form-step">
                        <div class="form-group">
                            <label>Nom de l'entreprise <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-building input-icon"></i>
                                <input type="text" id="company_name" name="company_name" placeholder="Tech Solutions SARL" required>
                                <div class="input-border-anim"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email professionnel <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" id="company_email" name="company_email" placeholder="contact@company.com" required>
                                <div class="input-border-anim"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Secteur <span class="required">*</span></label>
                                <div class="select-wrapper">
                                    <i class="fas fa-industry input-icon"></i>
                                    <select id="industry" name="company_sector" required>
                                        <option value="">Choisir...</option>
                                        <option value="tech">Technologie</option>
                                        <option value="retail">Commerce</option>
                                        <option value="services">Services</option>
                                        <option value="manufacturing">Manufacturage</option>
                                        <option value="healthcare">Santé</option>
                                        <option value="education">Éducation</option>
                                        <option value="finance">Finance</option>
                                        <option value="other">Autre</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nombre d'employés <span class="required">*</span></label>
                                <div class="select-wrapper">
                                    <i class="fas fa-users input-icon"></i>
                                    <select id="employees_count" name="company_employees_count" required>
                                        <option value="">Sélectionner...</option>
                                        <option value="1-10">1 – 10</option>
                                        <option value="11-50">11 – 50</option>
                                        <option value="51-100">51 – 100</option>
                                        <option value="101-500">101 – 500</option>
                                        <option value="500+">Plus de 500</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Location Info -->
                    <div id="step3" class="form-step">
                        <div class="form-group">
                            <label>Téléphone <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="tel" id="phone" name="company_phone" placeholder="+229 123 456 78" required>
                                <div class="input-border-anim"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Pays <span class="required">*</span></label>
                                <div class="select-wrapper">
                                    <i class="fas fa-globe input-icon" id="countryFlagIcon"></i>
                                    <select id="country" name="company_country" required>
                                        <option value="">Choisir...</option>
                                        <option value="benin" data-flag="🇧🇯">🇧🇯 Bénin</option>
                                        <option value="senegal" data-flag="🇸🇳">🇸🇳 Sénégal</option>
                                        <option value="cameroon" data-flag="🇨🇲">🇨🇲 Cameroun</option>
                                        <option value="ivory_coast" data-flag="🇨🇮">🇨🇮 Côte d'Ivoire</option>
                                        <option value="mali" data-flag="🇲🇱">🇲🇱 Mali</option>
                                        <option value="burkina" data-flag="🇧🇫">🇧🇫 Burkina</option>
                                        <option value="togo" data-flag="🇹🇬">🇹🇬 Togo</option>
                                        <option value="nigeria" data-flag="🇳🇬">🇳🇬 Nigeria</option>
                                        <option value="other" data-flag="🌍">🌍 Autre</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Ville <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="fas fa-map-marker-alt input-icon"></i>
                                    <input type="text" id="city" name="company_city" placeholder="Cotonou" required>
                                    <div class="input-border-anim"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Adresse complète</label>
                            <div class="input-wrapper">
                                <i class="fas fa-map-pin input-icon"></i>
                                <input type="text" id="address" name="company_address" placeholder="123 Rue de la Paix">
                                <div class="input-border-anim"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="form-navigation">
                        <button type="button" id="prevBtn" class="nav-btn prev-btn" style="display: none;">
                            <i class="fas fa-arrow-left"></i> Précédent
                        </button>
                        <button type="button" id="nextBtn" class="nav-btn next-btn">
                            Suivant <i class="fas fa-arrow-right"></i>
                        </button>
                        <button type="submit" id="submitBtn" class="btn-submit" style="display: none;">
                            <span class="btn-content"><i class="fas fa-rocket"></i> Créer mon compte gratuit</span>
                            <span class="btn-shine"></span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- FOOTER - Maintenu dans register-right -->
            <div class="register-footer">
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

                <p class="login-link footer-login-link">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}">Se connecter <i class="fas fa-arrow-right"></i></a>
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
   PAGE REGISTER — SCROLL VERTICAL UNIQUEMENT
═══════════════════════════════════════ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body.page-register {
    background: #F0EDE8;
    overflow-y: auto;
    overflow-x: hidden;
}

.register-wrapper {
    min-height: 100vh;
    background: #F0EDE8;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 72px 0 40px 0;
}

.register-container {
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
.register-left {
    background: #0A0A0A;
    padding: 28px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow-y: auto;
    overflow-x: hidden; /* ← Supprime le scroll horizontal */
    max-height: 680px;
    width: 100%;
}

/* Suppression de tout ce qui pourrait créer un overflow */
.register-left-content {
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

.register-left h2 {
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

/* ─── RIGHT PANEL CARROUSEL + FOOTER ─── */
.register-right {
    background: #fff;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    max-height: 680px;
}

.form-progress {
    display: flex;
    align-items: center;
    padding: 20px 32px 0;
    gap: 0;
    flex-shrink: 0;
}
.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    transition: all 0.3s;
}
.step-circle {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 2px solid #ebebeb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    color: #ccc;
    background: #fff;
    transition: all 0.3s;
    font-family: 'Clash Display', sans-serif;
}
.step-label {
    font-size: 10px;
    font-weight: 600;
    color: #ccc;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: color 0.3s;
}
.progress-step.active .step-circle {
    border-color: #FF6200;
    background: #FF6200;
    color: #fff;
    box-shadow: 0 4px 12px rgba(255, 98, 0, 0.3);
}
.progress-step.active .step-label { color: #FF6200; }
.progress-step.done .step-circle {
    border-color: #FF6200;
    background: #FF6200;
    color: #fff;
}
.progress-step.done .step-label { color: #FF6200; }
.progress-line {
    flex: 1;
    height: 2px;
    background: #ebebeb;
    margin: 0 10px;
    margin-bottom: 22px;
    transition: background 0.3s;
}
.progress-line.done { background: #FF6200; }

.register-right-content {
    padding: 20px 32px 16px;
    flex-shrink: 0;
}

.form-header { margin-bottom: 16px; }
.form-header h1 {
    font-family: 'Clash Display', sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: #0A0A0A;
    margin-bottom: 4px;
}
.subtitle { color: #999; font-size: 12px; }

.form-step {
    display: none;
    animation: fadeIn 0.3s ease;
}
.form-step.active { display: block; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}

.form-group { margin-bottom: 12px; }
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: #333;
    margin-bottom: 4px;
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
    font-size: 12px;
    pointer-events: none;
    transition: color 0.2s;
}
.input-wrapper:focus-within .input-icon { color: #FF6200; }

input, select {
    width: 100%;
    padding: 10px 12px 10px 36px;
    border: 1.5px solid #ebebeb;
    border-radius: 8px;
    font-size: 12.5px;
    font-family: inherit;
    color: #0A0A0A;
    background: #fafafa;
    transition: all 0.2s;
    outline: none;
}
input:focus, select:focus {
    border-color: rgba(255, 98, 0, 0.3);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(255, 98, 0, 0.06);
}

.select-wrapper { position: relative; }
.select-arrow {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #ccc;
    font-size: 11px;
    pointer-events: none;
}
select { padding: 10px 30px 10px 36px; appearance: none; cursor: pointer; }

.form-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 16px;
    margin-bottom: 0;
}
.nav-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    background: transparent;
}
.prev-btn {
    color: #666;
    background: #f5f5f5;
}
.prev-btn:hover { background: #ebebeb; }
.next-btn {
    background: #FF6200;
    color: white;
    margin-left: auto;
}
.next-btn:hover {
    background: #e05500;
    transform: translateX(2px);
}

.btn-submit {
    width: 100%;
    height: 44px;
    background: linear-gradient(135deg, #FF6200, #FF8C42);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-family: 'Clash Display', sans-serif;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(255, 98, 0, 0.3); }
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

/* ─── FOOTER DANS REGISTER-RIGHT ─── */
.register-footer {
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

.footer-login-link {
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

.login-link {
    text-align: center;
    font-size: 13px;
    color: #999;
}
.login-link a {
    color: #FF6200;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.login-link a:hover { gap: 8px; }

/* Scrollbars - UNIQUEMENT VERTICAUX */
.register-left::-webkit-scrollbar,
.register-right::-webkit-scrollbar {
    width: 4px;
}
.register-left::-webkit-scrollbar-track { background: #1a1a1a; }
.register-left::-webkit-scrollbar-thumb { background: #FF6200; border-radius: 4px; }
.register-right::-webkit-scrollbar-track { background: #f0f0f0; }
.register-right::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }

/* Responsive */
@media (max-width: 950px) {
    .register-container { grid-template-columns: 320px 1fr; margin: 0 16px; }
}
@media (max-width: 800px) {
    .register-container { grid-template-columns: 1fr; margin: 0 16px; border-radius: 20px; }
    .register-left { display: none; }
    .register-right { max-height: none; }
}
@media (max-width: 550px) {
    .form-row { grid-template-columns: 1fr; gap: 10px; }
    .register-right-content { padding: 16px 20px; }
    .form-progress { padding: 16px 20px 0; }
    .register-footer { padding: 16px 20px 20px; }
    .footer-social { grid-template-columns: 1fr; }
}
</style>
@endpush

@push('scripts')
<script>
    let currentStep = 1;
    const totalSteps = 3;
    let formData = {};

    function loadSavedData() {
        const saved = localStorage.getItem('mania_register_data');
        if (saved) {
            formData = JSON.parse(saved);
            if (formData.full_name) document.getElementById('full_name').value = formData.full_name;
            if (formData.personal_email) document.getElementById('personal_email').value = formData.personal_email;
            if (formData.password) document.getElementById('password').value = formData.password;
            if (formData.company_name) document.getElementById('company_name').value = formData.company_name;
            if (formData.company_email) document.getElementById('company_email').value = formData.company_email;
            if (formData.industry) document.getElementById('industry').value = formData.industry;
            if (formData.employees_count) document.getElementById('employees_count').value = formData.employees_count;
            if (formData.phone) document.getElementById('phone').value = formData.phone;
            if (formData.country) {
                document.getElementById('country').value = formData.country;
                updateCountryFlag();
            }
            if (formData.city) document.getElementById('city').value = formData.city;
            if (formData.address) document.getElementById('address').value = formData.address;
        }
    }

    function saveCurrentStepData() {
        formData = {
            full_name: document.getElementById('full_name')?.value || '',
            personal_email: document.getElementById('personal_email')?.value || '',
            password: document.getElementById('password')?.value || '',
            password_confirm: document.getElementById('password_confirm')?.value || '',
            company_name: document.getElementById('company_name')?.value || '',
            company_email: document.getElementById('company_email')?.value || '',
            industry: document.getElementById('industry')?.value || '',
            employees_count: document.getElementById('employees_count')?.value || '',
            phone: document.getElementById('phone')?.value || '',
            country: document.getElementById('country')?.value || '',
            city: document.getElementById('city')?.value || '',
            address: document.getElementById('address')?.value || ''
        };
        localStorage.setItem('mania_register_data', JSON.stringify(formData));
    }

    function updateCountryFlag() {
        const select = document.getElementById('country');
        const selectedOption = select.options[select.selectedIndex];
        const flagIcon = document.getElementById('countryFlagIcon');
        if (selectedOption && selectedOption.value && flagIcon) {
            const flag = selectedOption.textContent.charAt(0);
            if (flag === '🇧🇯' || flag === '🇸🇳' || flag === '🇨🇲' || flag === '🇨🇮' || flag === '🇲🇱' || flag === '🇧🇫' || flag === '🇹🇬' || flag === '🇳🇬' || flag === '🌍') {
                flagIcon.innerHTML = flag;
                flagIcon.style.fontSize = '14px';
            } else {
                flagIcon.innerHTML = '<i class="fas fa-globe"></i>';
            }
        }
    }

    function updateStep(step) {
        document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
        document.getElementById(`step${step}`).classList.add('active');
        
        document.querySelectorAll('.progress-step').forEach((el, idx) => {
            const stepNum = idx + 1;
            el.classList.remove('active', 'done');
            if (stepNum < step) el.classList.add('done');
            if (stepNum === step) el.classList.add('active');
        });
        
        document.querySelectorAll('.progress-line').forEach((el, idx) => {
            if (idx + 1 < step) el.classList.add('done');
            else el.classList.remove('done');
        });
        
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        
        prevBtn.style.display = step === 1 ? 'none' : 'flex';
        
        if (step === totalSteps) {
            nextBtn.style.display = 'none';
            submitBtn.style.display = 'flex';
        } else {
            nextBtn.style.display = 'flex';
            submitBtn.style.display = 'none';
        }
        
        const titles = {
            1: { title: 'Créer mon compte', subtitle: 'Commencez par vos informations personnelles' },
            2: { title: 'Votre entreprise', subtitle: 'Parlez-nous de votre structure' },
            3: { title: 'Localisation', subtitle: 'Où se trouve votre entreprise ?' }
        };
        document.getElementById('stepTitle').textContent = titles[step].title;
        document.getElementById('stepSubtitle').textContent = titles[step].subtitle;
        
        currentStep = step;
    }

    function validateStep(step) {
        if (step === 1) {
            const full_name = document.getElementById('full_name').value.trim();
            const personal_email = document.getElementById('personal_email').value.trim();
            const password = document.getElementById('password').value;
            const password_confirm = document.getElementById('password_confirm').value;
            
            if (!full_name) { showNotification('Veuillez entrer votre nom complet', 'error'); return false; }
            if (!personal_email || !personal_email.includes('@')) { showNotification('Email personnel invalide', 'error'); return false; }
            if (!password || password.length < 8) { showNotification('Le mot de passe doit contenir au moins 8 caractères', 'error'); return false; }
            if (password !== password_confirm) { showNotification('Les mots de passe ne correspondent pas', 'error'); return false; }
            return true;
        }
        
        if (step === 2) {
            const company_name = document.getElementById('company_name').value.trim();
            const company_email = document.getElementById('company_email').value.trim();
            const industry = document.getElementById('industry').value;
            const employees_count = document.getElementById('employees_count').value;
            
            if (!company_name) { showNotification('Veuillez entrer le nom de votre entreprise', 'error'); return false; }
            if (!company_email || !company_email.includes('@')) { showNotification('Email professionnel invalide', 'error'); return false; }
            if (!industry) { showNotification('Veuillez sélectionner votre secteur', 'error'); return false; }
            if (!employees_count) { showNotification('Veuillez sélectionner le nombre d\'employés', 'error'); return false; }
            return true;
        }
        
        if (step === 3) {
            const phone = document.getElementById('phone').value.trim();
            const country = document.getElementById('country').value;
            const city = document.getElementById('city').value.trim();
            
            if (!phone) { showNotification('Veuillez entrer votre numéro de téléphone', 'error'); return false; }
            if (!country) { showNotification('Veuillez sélectionner votre pays', 'error'); return false; }
            if (!city) { showNotification('Veuillez entrer votre ville', 'error'); return false; }
            return true;
        }
        
        return true;
    }

    function nextStep() {
        if (validateStep(currentStep)) {
            saveCurrentStepData();
            if (currentStep < totalSteps) updateStep(currentStep + 1);
        }
    }
    
    function prevStep() {
        if (currentStep > 1) {
            saveCurrentStepData();
            updateStep(currentStep - 1);
        }
    }
    
    function goToStep(step) {
        if (step < currentStep) {
            updateStep(step);
        } else if (step > currentStep) {
            let valid = true;
            for (let i = currentStep; i < step; i++) {
                if (!validateStep(i)) { valid = false; break; }
            }
            if (valid) {
                saveCurrentStepData();
                updateStep(step);
            }
        }
    }
    
    function handleFinalSubmit(event) {
        event.preventDefault();
        if (validateStep(3)) {
            saveCurrentStepData();
            console.log('Final submission data:', formData);
            showNotification('Compte créé avec succès ! Vérifiez votre email.', 'success');
            localStorage.removeItem('mania_register_data');
            setTimeout(() => { window.location.href = "{{ route('login') }}"; }, 2000);
        }
    }
    
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
    
    function setupAutoSave() {
        const inputs = document.querySelectorAll('#registerForm input, #registerForm select');
        inputs.forEach(input => {
            input.addEventListener('input', () => saveCurrentStepData());
            input.addEventListener('change', () => saveCurrentStepData());
        });
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        loadSavedData();
        setupAutoSave();
        updateStep(1);
        
        document.getElementById('nextBtn').addEventListener('click', nextStep);
        document.getElementById('prevBtn').addEventListener('click', prevStep);
        
        document.querySelectorAll('.progress-step').forEach((el, idx) => {
            el.addEventListener('click', () => goToStep(idx + 1));
        });
        
        document.getElementById('country').addEventListener('change', updateCountryFlag);
        updateCountryFlag();
    });
</script>
@endpush