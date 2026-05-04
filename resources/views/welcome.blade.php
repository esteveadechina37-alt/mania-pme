@extends('layouts.public')
@section('title', 'Mania-PME — Gérez vos RH sans friction')
@section('description', 'La plateforme RH pour les PME africaines. Simplifiez la gestion de vos ressources humaines.')
@section('bodyClass', 'page-home')

@section('content')

<!-- Hero Section - Image de fond couloir d'entreprise -->
<section class="hero-premium">
    <div class="hero-bg-image">
        <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=1600&h=900&fit=crop" alt="Modern office corridor">
        <div class="hero-overlay-dark"></div>
    </div>
    
    <div class="hero-container">
        <div class="hero-content">
            <div class="hero-badge reveal">
                <span class="badge-dot"></span>
                La solution RH #1 en Afrique
                <span class="badge-new">Nouveau</span>
            </div>
            
            <h1 class="hero-title reveal">
                Gérez vos <span class="gradient-orange">ressources humaines</span><br>
                avec une efficacité<span class="gradient-orange"> redoutable</span>
            </h1>
            
            <p class="hero-subtitle reveal reveal-delay-1">
                La plateforme tout-en-un qui centralise, automatise et optimise la gestion de vos équipes. 
                Gagnez du temps, réduisez les erreurs et concentrez-vous sur l'essentiel.
            </p>
            
            <div class="hero-stats reveal reveal-delay-2">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">PME clientes</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-number">12k+</div>
                    <div class="stat-label">Employés gérés</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Satisfaction</div>
                </div>
            </div>
            
            <div class="hero-buttons reveal reveal-delay-3">
                <a href="{{ route('register') }}" class="btn-primary">
                    <span>Commencer gratuitement</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{ url('/fonctionnalites') }}" class="btn-secondary">
                    <i class="fas fa-play-circle"></i>
                    <span>Voir la démo</span>
                </a>
            </div>
            
            <div class="hero-trust reveal reveal-delay-4">
                <div class="trust-item">
                    <i class="fas fa-check-circle"></i>
                    <span>14 jours d'essai gratuit</span>
                </div>
                <div class="trust-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Aucune carte bancaire</span>
                </div>
                <div class="trust-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Annulation à tout moment</span>
                </div>
            </div>
        </div>
        
        <div class="hero-visual reveal reveal-delay-2">
            <div class="dashboard-card">
                <div class="dashboard-header">
                    <div class="dashboard-dots">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="dashboard-title">Tableau de bord RH</div>
                    <div class="dashboard-user">
                        <i class="fas fa-bell"></i>
                        <div class="user-avatar">AD</div>
                    </div>
                </div>
                
                <div class="dashboard-stats">
                    <div class="stat-card">
                        <i class="fas fa-users"></i>
                        <div>
                            <h4>156</h4>
                            <p>Employés</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-calendar-check"></i>
                        <div>
                            <h4>8</h4>
                            <p>Congés en cours</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-chart-line"></i>
                        <div>
                            <h4>94%</h4>
                            <p>Productivité</p>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-chart">
                    <div class="chart-header">
                        <span>Présences hebdomadaires</span>
                        <span class="chart-trend">+12% <i class="fas fa-arrow-up"></i></span>
                    </div>
                    <div class="chart-bars">
                        <div class="chart-bar" style="height: 65px;"></div>
                        <div class="chart-bar" style="height: 82px;"></div>
                        <div class="chart-bar" style="height: 58px;"></div>
                        <div class="chart-bar" style="height: 74px;"></div>
                        <div class="chart-bar" style="height: 91px;"></div>
                        <div class="chart-bar" style="height: 68px;"></div>
                    </div>
                </div>
                
                <div class="dashboard-list">
                    <div class="list-header">
                        <span>Activité récente</span>
                        <a href="#">Voir tout <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="list-item">
                        <div class="item-avatar" style="background: #FF6200;">SM</div>
                        <div class="item-info">
                            <h4>Sophie M.</h4>
                            <p>Demande de congé approuvée</p>
                        </div>
                        <span class="item-time">Il y a 2h</span>
                    </div>
                    <div class="list-item">
                        <div class="item-avatar" style="background: #10B981;">JK</div>
                        <div class="item-info">
                            <h4>Jean K.</h4>
                            <p>Nouveau contrat signé</p>
                        </div>
                        <span class="item-time">Il y a 5h</span>
                    </div>
                    <div class="list-item">
                        <div class="item-avatar" style="background: #3B82F6;">AD</div>
                        <div class="item-info">
                            <h4>Amina D.</h4>
                            <p>Fiche de paie générée</p>
                        </div>
                        <span class="item-time">Hier</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="hero-scroll-indicator">
        <span>Découvrir</span>
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- Section: Comment ça marche - Fond clair -->
<section class="howitworks-light">
    <div class="container">
        <div class="section-header-light reveal">
            <span class="section-tag-light">Processus simple</span>
            <h2 class="section-title-light">Comment <span class="gradient-orange">ça marche</span> ?</h2>
            <p class="section-subtitle-light">Trois étapes simples pour transformer votre gestion RH</p>
        </div>

        <div class="steps-container">
            <!-- Étape 1 -->
            <div class="step-card reveal reveal-delay-1">
                <div class="step-number">01</div>
                <div class="step-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="step-content">
                    <h3>Créez votre compte</h3>
                    <p>Inscription en 2 minutes chrono. Aucune carte bancaire requise pour l'essai de 14 jours.</p>
                    <a href="{{ route('register') }}" class="step-link">Commencer <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="step-image">
                    <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=400&h=300&fit=crop" alt="Création de compte">
                </div>
            </div>

            <div class="step-connector">
                <i class="fas fa-arrow-down"></i>
            </div>

            <!-- Étape 2 -->
            <div class="step-card reverse reveal reveal-delay-2">
                <div class="step-number">02</div>
                <div class="step-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="step-content">
                    <h3>Ajoutez votre équipe</h3>
                    <p>Importez vos collaborateurs en un clic ou via fichier CSV. Générez automatiquement leurs fiches.</p>
                    <a href="#" class="step-link">En savoir plus <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="step-image">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400&h=300&fit=crop" alt="Gestion d'équipe">
                </div>
            </div>

            <div class="step-connector">
                <i class="fas fa-arrow-down"></i>
            </div>

            <!-- Étape 3 -->
            <div class="step-card reveal reveal-delay-3">
                <div class="step-number">03</div>
                <div class="step-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="step-content">
                    <h3>Gérez et analysez</h3>
                    <p>Accédez aux tableaux de bord, suivez les congés, gérez la paie et prenez des décisions éclairées.</p>
                    <a href="#" class="step-link">Explorer les fonctionnalités <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="step-image">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=300&fit=crop" alt="Analytics Dashboard">
                </div>
            </div>
        </div>

        <div class="steps-stats reveal reveal-delay-4">
            <div class="stats-item">
                <div class="stats-number">2min</div>
                <div class="stats-text">pour créer son compte</div>
            </div>
            <div class="stats-divider"></div>
            <div class="stats-item">
                <div class="stats-number">30s</div>
                <div class="stats-text">pour importer son équipe</div>
            </div>
            <div class="stats-divider"></div>
            <div class="stats-item">
                <div class="stats-number">24/7</div>
                <div class="stats-text">support disponible</div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Features - Fond blanc -->
<section class="features-light">
    <div class="container">
        <div class="section-header-light reveal">
            <span class="section-tag-light">Fonctionnalités exclusives</span>
            <h2 class="section-title-light">Tout ce dont vous avez <span class="gradient-orange">besoin</span></h2>
            <p class="section-subtitle-light">Une suite complète d'outils pour une gestion RH sans friction</p>
        </div>

        <div class="features-grid">
            <div class="feature-card reveal reveal-delay-1">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Gestion d'équipe centralisée</h3>
                <p>Toutes les informations de vos collaborateurs (contrats, documents, compétences) en un seul endroit sécurisé.</p>
                <div class="feature-tag">Nouveau</div>
            </div>

            <div class="feature-card reveal reveal-delay-2">
                <div class="feature-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3>Congés et absences simplifiés</h3>
                <p>Demandes en ligne, validation en un clic, calendrier visuel et solde automatiquement mis à jour.</p>
            </div>

            <div class="feature-card reveal reveal-delay-3">
                <div class="feature-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h3>Paie automatisée</h3>
                <p>Générez les bulletins de paie conformes, gérez les cotisations sociales et les déclarations fiscales.</p>
            </div>

            <div class="feature-card reveal reveal-delay-1">
                <div class="feature-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h3>Tableaux de bord intelligents</h3>
                <p>Visualisez vos KPI RH en temps réel : absentéisme, turnover, coût salarial, et bien plus.</p>
            </div>

            <div class="feature-card reveal reveal-delay-2">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Application mobile</h3>
                <p>Accédez à Mania-PME depuis votre smartphone, approuvez les demandes où que vous soyez.</p>
            </div>

            <div class="feature-card reveal reveal-delay-3">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Sécurité bancaire</h3>
                <p>Vos données RH sont protégées par un chiffrement de niveau militaire et des sauvegardes automatiques.</p>
            </div>
        </div>

        <div class="features-cta reveal">
            <a href="{{ url('/fonctionnalites') }}" class="link-arrow">
                Découvrir toutes les fonctionnalités <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Section: Tarifs - Fond gris clair -->
<section class="pricing-light">
    <div class="container">
        <div class="section-header-light reveal">
            <span class="section-tag-light">Tarifs transparents</span>
            <h2 class="section-title-light">Des plans pour <span class="gradient-orange">toutes les PME</span></h2>
            <p class="section-subtitle-light">Sans engagement, annulation à tout moment</p>
        </div>

        <div class="pricing-switch reveal">
            <span class="switch-label active" data-billing="monthly">Mensuel</span>
            <div class="switch-toggle" onclick="toggleBilling()">
                <div class="switch-knob"></div>
            </div>
            <span class="switch-label" data-billing="yearly">Annuel <span class="save-badge">-20%</span></span>
        </div>

        <div class="pricing-grid">
            <div class="pricing-card reveal reveal-delay-1">
                <h3>Starter</h3>
                <div class="price-monthly">
                    <span class="currency">0</span>
                    <span class="amount">FCFA</span>
                    <span class="period">/mois</span>
                </div>
                <div class="price-yearly" style="display: none;">
                    <span class="currency">0</span>
                    <span class="amount">FCFA</span>
                    <span class="period">/an</span>
                </div>
                <p class="price-desc">Pour tester la solution</p>
                <ul class="features-list">
                    <li><i class="fas fa-check-circle"></i> Jusqu'à 10 collaborateurs</li>
                    <li><i class="fas fa-check-circle"></i> Gestion d'équipe basique</li>
                    <li><i class="fas fa-check-circle"></i> Calendrier des congés</li>
                    <li><i class="fas fa-check-circle"></i> Support email</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-outline">Commencer <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="pricing-card featured reveal reveal-delay-2">
                <div class="popular-badge">🔥 Le plus populaire</div>
                <h3>Pro</h3>
                <div class="price-monthly">
                    <span class="currency">4 999</span>
                    <span class="amount">FCFA</span>
                    <span class="period">/mois</span>
                </div>
                <div class="price-yearly" style="display: none;">
                    <span class="currency">47 990</span>
                    <span class="amount">FCFA</span>
                    <span class="period">/an</span>
                    <span class="saving-badge">Économisez 12 000 FCFA</span>
                </div>
                <p class="price-desc">Pour les entreprises en croissance</p>
                <ul class="features-list">
                    <li><i class="fas fa-check-circle"></i> Jusqu'à 100 collaborateurs</li>
                    <li><i class="fas fa-check-circle"></i> Gestion d'équipe complète</li>
                    <li><i class="fas fa-check-circle"></i> Paie automatique</li>
                    <li><i class="fas fa-check-circle"></i> Tableaux de bord avancés</li>
                    <li><i class="fas fa-check-circle"></i> Support prioritaire</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-primary-full">Commencer <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="pricing-card reveal reveal-delay-3">
                <h3>Enterprise</h3>
                <div class="price-custom">
                    <span class="currency">Sur mesure</span>
                </div>
                <p class="price-desc">Pour les grandes structures</p>
                <ul class="features-list">
                    <li><i class="fas fa-check-circle"></i> Collaborateurs illimités</li>
                    <li><i class="fas fa-check-circle"></i> Toutes les fonctionnalités</li>
                    <li><i class="fas fa-check-circle"></i> API et intégrations</li>
                    <li><i class="fas fa-check-circle"></i> Onboarding dédié</li>
                    <li><i class="fas fa-check-circle"></i> Support 24/7</li>
                </ul>
                <a href="{{ url('/contact') }}" class="btn-outline">Nous contacter <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Section: Témoignages - Fond blanc -->
<section class="testimonials-light">
    <div class="container">
        <div class="section-header-light reveal">
            <span class="section-tag-light">Ils nous font confiance</span>
            <h2 class="section-title-light">Ce que disent <span class="gradient-orange">nos clients</span></h2>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card reveal reveal-delay-1">
                <div class="testimonial-quote">
                    <i class="fas fa-quote-left"></i>
                </div>
                <p class="testimonial-text">"Mania-PME a transformé notre gestion RH. Nous avons gagné 10 heures par semaine et nos employés adorent la simplicité d'utilisation."</p>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background: linear-gradient(135deg, #FF6200, #FF8C42);">SK</div>
                    <div>
                        <h4>Sophie Kane</h4>
                        <p>CEO, TechAfrica Sénégal</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card reveal reveal-delay-2">
                <div class="testimonial-quote">
                    <i class="fas fa-quote-left"></i>
                </div>
                <p class="testimonial-text">"Le support client est exceptionnel et l'interface est vraiment intuitive. Je recommande à toutes les PME qui veulent se professionnaliser."</p>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background: linear-gradient(135deg, #10B981, #059669);">DM</div>
                    <div>
                        <h4>David Mensah</h4>
                        <p>HR Director, Ghana Trading Co.</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card reveal reveal-delay-3">
                <div class="testimonial-quote">
                    <i class="fas fa-quote-left"></i>
                </div>
                <p class="testimonial-text">"Enfin un outil RH pensé pour l'Afrique. Les fonctionnalités sont complètes et les prix sont accessibles pour notre marché."</p>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background: linear-gradient(135deg, #3B82F6, #2563EB);">FZ</div>
                    <div>
                        <h4>Fatima Zohra</h4>
                        <p>Founder, Algérie Digital</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="clients-logos reveal reveal-delay-4">
            <p>Ils utilisent Mania-PME au quotidien</p>
            <div class="logos-grid">
                <div class="logo-item">TechAfrica</div>
                <div class="logo-item">Ghana Trading</div>
                <div class="logo-item">Algérie Digital</div>
                <div class="logo-item">StartUP Hub</div>
                <div class="logo-item">InnovationLab</div>
                <div class="logo-item">AfricaTech</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final - Dégradé orange -->
<section class="cta-gradient">
    <div class="cta-container">
        <div class="cta-content reveal">
            <h2>Prêt à transformer votre <span>gestion RH</span> ?</h2>
            <p>Rejoignez plus de 500 PME africaines qui optimisent déjà leurs ressources humaines avec Mania-PME.</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn-cta-primary">
                    <i class="fas fa-rocket"></i>
                    <span>Créer mon compte gratuit</span>
                </a>
                <a href="{{ url('/contact') }}" class="btn-cta-secondary">
                    <i class="fas fa-headset"></i>
                    <span>Contacter le support</span>
                </a>
            </div>
            <div class="cta-trust">
                <span><i class="fas fa-shield-alt"></i> 14 jours d'essai</span>
                <span><i class="fas fa-credit-card"></i> Sans carte bancaire</span>
                <span><i class="fas fa-clock"></i> Annulation à tout moment</span>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ─────────── VARIABLES ─────────── */
:root {
    --orange: #FF6200;
    --orange-light: #FF8C42;
    --orange-dark: #E05500;
    --white: #FFFFFF;
    --black: #0A0A0A;
    --gray-50: #F9FAFB;
    --gray-100: #F3F4F6;
    --gray-200: #E5E7EB;
    --gray-300: #D1D5DB;
    --gray-400: #9CA3AF;
    --gray-500: #6B7280;
    --gray-600: #4B5563;
    --gray-700: #374151;
    --gray-800: #1F2937;
    --gray-900: #111827;
}

/* ─────────── HERO SECTION AVEC IMAGE COULOIR ENTREPRISE ─────────── */
.hero-premium {
    position: relative;
    min-height: 100vh;
    padding: 100px 5% 80px;
    overflow: hidden;
}

.hero-bg-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
}

.hero-bg-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-overlay-dark {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.75) 50%, rgba(0,0,0,0.85) 100%);
}

.hero-container {
    position: relative;
    z-index: 2;
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,98,0,0.15);
    backdrop-filter: blur(10px);
    padding: 8px 18px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
    color: var(--orange);
    margin-bottom: 24px;
    border: 1px solid rgba(255,98,0,0.3);
    width: fit-content;
}

.badge-dot {
    width: 8px;
    height: 8px;
    background: var(--orange);
    border-radius: 50%;
    animation: pulse 1.5s ease infinite;
}

.badge-new {
    background: rgba(255,98,0,0.2);
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
}

.hero-title {
    font-family: 'Clash Display', sans-serif;
    font-size: 52px;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 24px;
    color: var(--white);
}

.gradient-orange {
    background: linear-gradient(135deg, var(--orange) 0%, var(--orange-light) 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.hero-subtitle {
    font-size: 18px;
    color: rgba(255,255,255,0.7);
    line-height: 1.6;
    margin-bottom: 32px;
}

.hero-stats {
    display: flex;
    align-items: center;
    gap: 40px;
    margin-bottom: 32px;
    padding: 20px 0;
    border-top: 1px solid rgba(255,255,255,0.1);
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.stat-number {
    font-family: 'Clash Display', sans-serif;
    font-size: 32px;
    font-weight: 700;
    color: var(--orange);
}

.stat-label {
    font-size: 12px;
    color: rgba(255,255,255,0.6);
}

.stat-divider {
    width: 1px;
    height: 30px;
    background: rgba(255,255,255,0.2);
}

.hero-buttons {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 32px;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 14px 28px;
    background: linear-gradient(135deg, var(--orange) 0%, var(--orange-light) 100%);
    color: var(--white);
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(255,98,0,0.4);
    gap: 16px;
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    color: var(--white);
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid rgba(255,255,255,0.2);
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: rgba(255,255,255,0.2);
    transform: translateY(-2px);
}

.hero-trust {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
}

.trust-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: rgba(255,255,255,0.6);
}

.trust-item i {
    color: var(--orange);
}

.hero-scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    color: rgba(255,255,255,0.5);
    font-size: 12px;
    animation: bounce 2s ease infinite;
    z-index: 2;
}

@keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50% { transform: translateX(-50%) translateY(10px); }
}

/* Dashboard Card - Glassmorphism */
.dashboard-card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,0.1);
    overflow: hidden;
    padding: 20px;
}

.dashboard-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.dashboard-dots {
    display: flex;
    gap: 6px;
}

.dashboard-dots span {
    width: 10px;
    height: 10px;
    background: rgba(255,255,255,0.3);
    border-radius: 50%;
}

.dashboard-title {
    font-size: 12px;
    color: rgba(255,255,255,0.6);
}

.dashboard-user {
    display: flex;
    align-items: center;
    gap: 12px;
}

.dashboard-user i {
    color: rgba(255,255,255,0.6);
}

.user-avatar {
    width: 32px;
    height: 32px;
    background: var(--orange);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    color: var(--white);
}

.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 24px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
}

.stat-card i {
    font-size: 24px;
    color: var(--orange);
}

.stat-card h4 {
    font-size: 18px;
    font-weight: 700;
    color: var(--white);
}

.stat-card p {
    font-size: 11px;
    color: rgba(255,255,255,0.6);
}

.dashboard-chart {
    margin-bottom: 24px;
    padding: 16px;
    background: rgba(255,255,255,0.03);
    border-radius: 16px;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    font-size: 12px;
    color: rgba(255,255,255,0.6);
}

.chart-trend {
    color: #10B981;
}

.chart-bars {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    height: 100px;
}

.chart-bar {
    flex: 1;
    background: linear-gradient(180deg, var(--orange) 0%, var(--orange-light) 100%);
    border-radius: 8px 8px 4px 4px;
    min-height: 20px;
}

.dashboard-list {
    padding: 16px;
    background: rgba(255,255,255,0.03);
    border-radius: 16px;
}

.list-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    font-size: 12px;
    color: rgba(255,255,255,0.6);
}

.list-header a {
    color: var(--orange);
    text-decoration: none;
    font-size: 11px;
}

.list-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.item-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    color: var(--white);
}

.item-info {
    flex: 1;
}

.item-info h4 {
    font-size: 13px;
    font-weight: 600;
    color: var(--white);
}

.item-info p {
    font-size: 11px;
    color: rgba(255,255,255,0.6);
}

.item-time {
    font-size: 10px;
    color: rgba(255,255,255,0.5);
}

/* ─────────── SECTION COMMENT ÇA MARCHE (FOND CLAIR) ─────────── */
.howitworks-light {
    padding: 100px 5%;
    background: var(--white);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
}

.section-header-light {
    text-align: center;
    margin-bottom: 60px;
}

.section-tag-light {
    display: inline-block;
    background: rgba(255,98,0,0.1);
    color: var(--orange);
    font-size: 12px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 100px;
    margin-bottom: 16px;
}

.section-title-light {
    font-family: 'Clash Display', sans-serif;
    font-size: 42px;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 16px;
}

.section-subtitle-light {
    font-size: 16px;
    color: var(--gray-500);
    max-width: 600px;
    margin: 0 auto;
}

.steps-container {
    max-width: 1000px;
    margin: 0 auto;
}

.step-card {
    display: flex;
    align-items: center;
    gap: 48px;
    margin-bottom: 40px;
    padding: 32px;
    background: var(--white);
    border-radius: 32px;
    border: 1px solid var(--gray-200);
    position: relative;
    transition: all 0.4s ease;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.step-card:hover {
    transform: translateY(-4px);
    border-color: var(--orange);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.step-card.reverse {
    flex-direction: row-reverse;
}

.step-number {
    position: absolute;
    top: -20px;
    left: 30px;
    font-size: 70px;
    font-weight: 800;
    color: rgba(255,98,0,0.08);
    font-family: 'Clash Display', sans-serif;
}

.step-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(255,98,0,0.15) 0%, rgba(255,98,0,0.05) 100%);
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.step-icon i {
    font-size: 36px;
    color: var(--orange);
}

.step-content {
    flex: 1;
}

.step-content h3 {
    font-size: 24px;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 12px;
}

.step-content p {
    color: var(--gray-500);
    line-height: 1.6;
    margin-bottom: 16px;
}

.step-link {
    color: var(--orange);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.step-link:hover {
    gap: 10px;
}

.step-image {
    width: 220px;
    height: 160px;
    flex-shrink: 0;
    border-radius: 20px;
    overflow: hidden;
}

.step-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.step-connector {
    text-align: center;
    margin: -20px 0;
}

.step-connector i {
    font-size: 20px;
    color: var(--orange);
    opacity: 0.5;
}

.steps-stats {
    display: flex;
    justify-content: center;
    gap: 60px;
    margin-top: 60px;
    padding-top: 40px;
    border-top: 1px solid var(--gray-200);
}

.stats-item {
    text-align: center;
}

.stats-number {
    font-family: 'Clash Display', sans-serif;
    font-size: 28px;
    font-weight: 700;
    color: var(--orange);
}

.stats-text {
    font-size: 12px;
    color: var(--gray-500);
}

.stats-divider {
    width: 1px;
    height: 40px;
    background: var(--gray-200);
}

/* ─────────── FEATURES (FOND BLANC) ─────────── */
.features-light {
    padding: 100px 5%;
    background: var(--gray-50);
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 32px;
    margin-bottom: 48px;
}

.feature-card {
    padding: 32px;
    background: var(--white);
    border-radius: 24px;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-8px);
    border-color: var(--orange);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.feature-icon {
    width: 56px;
    height: 56px;
    background: rgba(255,98,0,0.1);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.feature-icon i {
    font-size: 28px;
    color: var(--orange);
}

.feature-card h3 {
    font-size: 18px;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 12px;
}

.feature-card p {
    font-size: 14px;
    color: var(--gray-500);
    line-height: 1.6;
    margin-bottom: 16px;
}

.feature-tag {
    display: inline-block;
    background: rgba(255,98,0,0.1);
    color: var(--orange);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
}

.features-cta {
    text-align: center;
}

.link-arrow {
    color: var(--orange);
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.link-arrow:hover {
    gap: 12px;
}

/* ─────────── PRICING (FOND GRIS CLAIR) ─────────── */
.pricing-light {
    padding: 100px 5%;
    background: var(--white);
}

.pricing-switch {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    margin-bottom: 48px;
}

.switch-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--gray-500);
    cursor: pointer;
}

.switch-label.active {
    color: var(--orange);
}

.switch-toggle {
    width: 50px;
    height: 28px;
    background: var(--gray-200);
    border-radius: 100px;
    cursor: pointer;
    position: relative;
    transition: background 0.3s ease;
}

.switch-toggle.active {
    background: var(--orange);
}

.switch-knob {
    width: 22px;
    height: 22px;
    background: var(--white);
    border-radius: 50%;
    position: absolute;
    top: 3px;
    left: 3px;
    transition: left 0.3s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.switch-toggle.active .switch-knob {
    left: 25px;
}

.save-badge {
    background: var(--orange);
    color: var(--white);
    padding: 2px 8px;
    border-radius: 100px;
    font-size: 10px;
    margin-left: 6px;
}

.pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 32px;
    max-width: 1200px;
    margin: 0 auto;
}

.pricing-card {
    background: var(--white);
    padding: 40px 32px;
    border-radius: 32px;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    border: 1px solid var(--gray-200);
}

.pricing-card.featured {
    border: 2px solid var(--orange);
    transform: scale(1.05);
    box-shadow: 0 20px 40px rgba(255,98,0,0.15);
}

.popular-badge {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--orange);
    color: var(--white);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.pricing-card h3 {
    font-size: 24px;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 16px;
}

.price-monthly, .price-yearly {
    margin-bottom: 8px;
}

.currency {
    font-size: 36px;
    font-weight: 700;
    color: var(--orange);
}

.amount {
    font-size: 36px;
    font-weight: 700;
    color: var(--orange);
}

.period {
    font-size: 14px;
    color: var(--gray-500);
}

.saving-badge {
    display: block;
    font-size: 12px;
    color: #10B981;
    margin-top: 8px;
}

.price-custom .currency {
    font-size: 20px;
}

.price-desc {
    font-size: 13px;
    color: var(--gray-500);
    margin-bottom: 24px;
}

.features-list {
    list-style: none;
    text-align: left;
    margin: 24px 0;
}

.features-list li {
    padding: 10px 0;
    font-size: 13px;
    color: var(--gray-600);
    display: flex;
    align-items: center;
    gap: 10px;
}

.features-list li i {
    color: var(--orange);
    font-size: 14px;
}

.btn-primary-full, .btn-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary-full {
    background: linear-gradient(135deg, var(--orange) 0%, var(--orange-light) 100%);
    color: var(--white);
}

.btn-primary-full:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255,98,0,0.3);
}

.btn-outline {
    background: transparent;
    color: var(--gray-700);
    border: 2px solid var(--gray-200);
}

.btn-outline:hover {
    border-color: var(--orange);
    background: rgba(255,98,0,0.05);
}

/* ─────────── TESTIMONIALS (FOND BLANC) ─────────── */
.testimonials-light {
    padding: 100px 5%;
    background: var(--gray-50);
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 32px;
    max-width: 1200px;
    margin: 0 auto;
}

.testimonial-card {
    padding: 32px;
    background: var(--white);
    border-radius: 24px;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
}

.testimonial-card:hover {
    transform: translateY(-4px);
    border-color: var(--orange);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.testimonial-quote i {
    font-size: 32px;
    color: rgba(255,98,0,0.2);
    margin-bottom: 16px;
}

.testimonial-text {
    font-size: 14px;
    line-height: 1.7;
    color: var(--gray-600);
    margin-bottom: 20px;
    font-style: italic;
}

.testimonial-rating {
    display: flex;
    gap: 4px;
    margin-bottom: 20px;
}

.testimonial-rating i {
    font-size: 14px;
    color: #FFB800;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 12px;
}

.author-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    color: var(--white);
}

.testimonial-author h4 {
    font-size: 14px;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 2px;
}

.testimonial-author p {
    font-size: 12px;
    color: var(--gray-500);
}

.clients-logos {
    text-align: center;
    margin-top: 60px;
}

.clients-logos p {
    font-size: 12px;
    color: var(--gray-500);
    margin-bottom: 24px;
}

.logos-grid {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 48px;
}

.logo-item {
    font-size: 14px;
    font-weight: 600;
    color: var(--gray-400);
    letter-spacing: 1px;
    transition: color 0.3s ease;
}

.logo-item:hover {
    color: var(--orange);
}

/* ─────────── CTA FINAL GRADIENT ─────────── */
.cta-gradient {
    padding: 80px 5%;
    background: linear-gradient(135deg, #FF6200 0%, #FF8C42 100%);
}

.cta-container {
    max-width: 800px;
    margin: 0 auto;
}

.cta-content {
    text-align: center;
}

.cta-content h2 {
    font-family: 'Clash Display', sans-serif;
    font-size: 42px;
    font-weight: 700;
    color: var(--white);
    margin-bottom: 16px;
}

.cta-content h2 span {
    text-decoration: underline;
    text-decoration-thickness: 2px;
    text-underline-offset: 8px;
}

.cta-content p {
    font-size: 16px;
    color: rgba(255,255,255,0.9);
    margin-bottom: 32px;
}

.cta-buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 32px;
}

.btn-cta-primary {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 16px 32px;
    background: var(--white);
    color: var(--orange);
    border-radius: 60px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.btn-cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.2);
    gap: 16px;
}

.btn-cta-secondary {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 16px 32px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    color: var(--white);
    border-radius: 60px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.3);
}

.btn-cta-secondary:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
}

.cta-trust {
    display: flex;
    justify-content: center;
    gap: 24px;
    flex-wrap: wrap;
}

.cta-trust span {
    font-size: 13px;
    color: rgba(255,255,255,0.8);
    display: flex;
    align-items: center;
    gap: 6px;
}

.cta-trust i {
    font-size: 14px;
}

/* ─────────── ANIMATIONS ─────────── */
.reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease;
}

.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}

.reveal-delay-1 { transition-delay: 0.1s; }
.reveal-delay-2 { transition-delay: 0.2s; }
.reveal-delay-3 { transition-delay: 0.3s; }
.reveal-delay-4 { transition-delay: 0.4s; }

/* ─────────── RESPONSIVE MOBILE OPTIMISÉ ─────────── */
@media (max-width: 1024px) {
    .hero-container {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .hero-title {
        font-size: 40px;
    }
    
    .step-card, .step-card.reverse {
        flex-direction: column;
        text-align: center;
    }
    
    .step-icon {
        margin: 0 auto;
    }
    
    .step-number {
        left: 50%;
        transform: translateX(-50%);
    }
    
    .pricing-card.featured {
        transform: scale(1);
    }
    
    .section-title-light {
        font-size: 32px;
    }
}

@media (max-width: 768px) {
    /* Hero Section - Mobile Optimisé */
    .hero-premium {
        padding: 80px 5% 60px;
        min-height: auto;
    }
    
    .hero-title {
        font-size: 28px;
        line-height: 1.3;
    }
    
    .hero-subtitle {
        font-size: 14px;
        margin-bottom: 24px;
    }
    
    /* Masquer les statistiques sur mobile (optionnel mais aère) */
    .hero-stats {
        gap: 20px;
        padding: 12px 0;
        margin-bottom: 24px;
    }
    
    .stat-number {
        font-size: 22px;
    }
    
    .stat-label {
        font-size: 10px;
    }
    
    /* Masquer le dashboard sur mobile */
    .hero-visual {
        display: none;
    }
    
    /* Masquer l'indicateur de scroll sur mobile */
    .hero-scroll-indicator {
        display: none;
    }
    
    /* Badge plus petit sur mobile */
    .hero-badge {
        padding: 5px 12px;
        font-size: 10px;
        margin-bottom: 16px;
    }
    
    .badge-new {
        font-size: 8px;
        padding: 1px 6px;
    }
    
    /* Boutons en colonne sur mobile */
    .hero-buttons {
        flex-direction: column;
        gap: 12px;
        margin-bottom: 24px;
    }
    
    .btn-primary, .btn-secondary {
        width: 100%;
        justify-content: center;
        padding: 12px 20px;
    }
    
    /* Trust items en ligne sur mobile */
    .hero-trust {
        flex-direction: column;
        gap: 10px;
    }
    
    .trust-item {
        font-size: 12px;
    }
    
    /* Section Comment ça marche - Mobile */
    .howitworks-light {
        padding: 60px 5%;
    }
    
    .section-header-light {
        margin-bottom: 40px;
    }
    
    .section-title-light {
        font-size: 28px;
    }
    
    .section-subtitle-light {
        font-size: 14px;
    }
    
    .step-card {
        padding: 24px 20px;
        margin-bottom: 30px;
    }
    
    .step-icon {
        width: 60px;
        height: 60px;
    }
    
    .step-icon i {
        font-size: 28px;
    }
    
    .step-content h3 {
        font-size: 20px;
    }
    
    .step-content p {
        font-size: 14px;
    }
    
    .step-image {
        width: 100%;
        height: 140px;
    }
    
    .step-connector {
        margin: -10px 0;
    }
    
    .steps-stats {
        flex-direction: column;
        gap: 20px;
    }
    
    .stats-divider {
        display: none;
    }
    
    /* Features - Mobile */
    .features-light {
        padding: 60px 5%;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .feature-card {
        padding: 24px;
    }
    
    /* Pricing - Mobile */
    .pricing-light {
        padding: 60px 5%;
    }
    
    .pricing-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    
    .pricing-card {
        padding: 30px 24px;
    }
    
    .pricing-switch {
        margin-bottom: 32px;
    }
    
    /* Testimonials - Mobile */
    .testimonials-light {
        padding: 60px 5%;
    }
    
    .testimonials-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .testimonial-card {
        padding: 24px;
    }
    
    .logos-grid {
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .logo-item {
        font-size: 10px;
    }
    
    /* CTA - Mobile */
    .cta-gradient {
        padding: 50px 5%;
    }
    
    .cta-content h2 {
        font-size: 24px;
    }
    
    .cta-content p {
        font-size: 14px;
        margin-bottom: 24px;
    }
    
    .cta-buttons {
        flex-direction: column;
        gap: 12px;
    }
    
    .btn-cta-primary, .btn-cta-secondary {
        width: 100%;
        justify-content: center;
        padding: 14px 20px;
    }
    
    .cta-trust {
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 24px;
    }
    
    .step-card {
        padding: 20px 16px;
    }
    
    .feature-card {
        padding: 20px;
    }
    
    .pricing-card {
        padding: 24px 20px;
    }
    
    .testimonial-card {
        padding: 20px;
    }
    
    .cta-content h2 {
        font-size: 22px;
    }
}
</style>
@endpush

@push('scripts')
<script>
    // Intersection Observer for Reveal
    const revealElements = document.querySelectorAll('.reveal');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    revealElements.forEach(el => observer.observe(el));

    // Toggle billing (monthly/yearly)
    let isMonthly = true;
    
    function toggleBilling() {
        const toggle = document.querySelector('.switch-toggle');
        const monthlyPrices = document.querySelectorAll('.price-monthly');
        const yearlyPrices = document.querySelectorAll('.price-yearly');
        const switchLabels = document.querySelectorAll('.switch-label');
        
        isMonthly = !isMonthly;
        
        if (isMonthly) {
            monthlyPrices.forEach(p => p.style.display = 'block');
            yearlyPrices.forEach(p => p.style.display = 'none');
            switchLabels[0].classList.add('active');
            switchLabels[1].classList.remove('active');
        } else {
            monthlyPrices.forEach(p => p.style.display = 'none');
            yearlyPrices.forEach(p => p.style.display = 'block');
            switchLabels[0].classList.remove('active');
            switchLabels[1].classList.add('active');
        }
        
        toggle.classList.toggle('active');
    }
    
    window.toggleBilling = toggleBilling;
</script>
@endpush