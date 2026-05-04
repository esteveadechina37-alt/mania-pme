@extends('layouts.public')
@section('title', 'Fonctionnalités — Mania-PME')
@section('description', 'Découvrez toutes les fonctionnalités de Mania-PME pour gérer vos RH efficacement')
@section('bodyClass', 'page-fonctionnalites')

@section('content')
<section class="features-hero" style="background: var(--black); padding: 120px 5% 80px; text-align: center; position: relative; overflow: hidden; isolation: isolate;">
    
    {{-- Texture grain --}}
    <div style="position: absolute; inset: 0; background-image: radial-gradient(circle at 30% 40%, rgba(255,98,0,0.08) 1px, transparent 1px), radial-gradient(circle at 70% 60%, rgba(255,140,66,0.06) 1px, transparent 1px); background-size: 50px 50px, 70px 70px; pointer-events: none; z-index: 0;"></div>
    
    {{-- Ligne décorative orange --}}
    <div style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 1px; height: 120px; background: linear-gradient(to bottom, var(--orange), transparent); pointer-events: none; z-index: 0;"></div>
    
    {{-- Cercles subtils --}}
    <div style="position: absolute; width: 300px; height: 300px; border: 1px solid rgba(255,98,0,0.08); border-radius: 50%; top: -100px; right: -80px; pointer-events: none; z-index: 0;"></div>
    <div style="position: absolute; width: 200px; height: 200px; border: 1px solid rgba(255,140,66,0.05); border-radius: 50%; bottom: -60px; left: -40px; pointer-events: none; z-index: 0;"></div>

    <div class="container" style="position: relative; z-index: 2; max-width: 1200px; margin: 0 auto;">
        
        {{-- Badge --}}
        <div class="reveal" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255,98,0,0.1); border: 1px solid rgba(255,98,0,0.2); padding: 6px 18px; border-radius: 50px; margin-bottom: 20px; font-size: 12px; font-weight: 500; color: var(--orange); letter-spacing: 1px; text-transform: uppercase;">
            <i class="fas fa-cube" style="font-size: 10px;"></i>
            Fonctionnalités
        </div>

        <h1 class="page-title reveal" style="font-family: 'Clash Display', sans-serif; font-size: 56px; font-weight: 700; margin-bottom: 20px; color: var(--white); line-height: 1.1; letter-spacing: -1px; max-width: 800px; margin-left: auto; margin-right: auto;">
            Des fonctionnalités<br>
            <span style="color: var(--orange);">puissantes et intuitives</span>
        </h1>
        
        <p class="page-subtitle reveal reveal-delay-1" style="font-size: 18px; color: rgba(255,255,255,0.6); max-width: 550px; margin: 0 auto 32px; line-height: 1.7;">
            Découvrez tout ce que Mania-PME peut faire pour votre gestion RH. Des outils pensés pour les PME africaines.
        </p>

        {{-- Stats mini --}}
        <!-- <div class="reveal reveal-delay-2" style="display: flex; gap: 40px; justify-content: center; flex-wrap: wrap;">
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">8</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Modules</div>
            </div>
            <div style="width: 1px; background: rgba(255,255,255,0.1);"></div>
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">100%</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Afrique</div>
            </div>
            <div style="width: 1px; background: rgba(255,255,255,0.1);"></div>
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">24/7</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Support</div>
            </div>
        </div> -->
    </div>
</section>
<!-- <section class="features-hero">
    <div class="container">
        <h1 class="page-title reveal">
            Fonctionnalités puissantes et intuitives
        </h1>
        <p class="page-subtitle reveal reveal-delay-1">
            Découvrez tout ce que Mania-PME peut faire pour votre gestion RH
        </p>
    </div>
</section> -->

<section class="features-main">
    <div class="container">
        <div class="features-list">
            <!-- Feature 1 -->
            <div class="feature-row reveal">
                <div class="feature-num">01</div>
                <div class="feature-content">
                    <h2>Gestion des employés</h2>
                    <p>Créez des fiches complètes pour chaque collaborateur avec toutes les informations pertinentes. Gérez les contrats, les qualifications, les coordonnées et bien plus encore. Construisez un organigramme dynamique de votre entreprise.</p>
                    <ul class="feature-benefits">
                        <li><i class="fas fa-check"></i> Profils détaillés avec photo</li>
                        <li><i class="fas fa-check"></i> Historique des modifications</li>
                        <li><i class="fas fa-check"></i> Documents associés</li>
                        <li><i class="fas fa-check"></i> Organigramme interactif</li>
                    </ul>
                </div>
                <div class="feature-visual">
                    <div class="feature-icon-large">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="feature-row reveal reveal-delay-1">
                <div class="feature-num">02</div>
                <div class="feature-content">
                    <h2>Gestion des congés et absences</h2>
                    <p>Simplifiez les demandes de congés avec un système de workflow multi-niveaux. Les employés demandent, les managers valident, les RH consolident. Le solde se met à jour automatiquement et les notifications gardent tout le monde informé.</p>
                    <ul class="feature-benefits">
                        <li><i class="fas fa-check"></i> Demandes en un clic</li>
                        <li><i class="fas fa-check"></i> Workflow de validation</li>
                        <li><i class="fas fa-check"></i> Solde automatique</li>
                        <li><i class="fas fa-check"></i> Calendrier partagé</li>
                    </ul>
                </div>
                <div class="feature-visual">
                    <div class="feature-icon-large" style="background: rgba(255, 98, 0, 0.1); color: var(--orange);">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="feature-row reveal reveal-delay-2">
                <div class="feature-num">03</div>
                <div class="feature-content">
                    <h2>Paie et comptabilité</h2>
                    <p>Générez les bulletins de paie en quelques secondes. Gérez les cotisations sociales, les impôts, les primes et les déductions. Exportez directement vers votre logiciel comptable. Conservez un historique complet de la paie de chaque employé.</p>
                    <ul class="feature-benefits">
                        <li><i class="fas fa-check"></i> Bulletins automatiques</li>
                        <li><i class="fas fa-check"></i> Calcul des cotisations</li>
                        <li><i class="fas fa-check"></i> Export comptable</li>
                        <li><i class="fas fa-check"></i> Signature numérique</li>
                    </ul>
                </div>
                <div class="feature-visual">
                    <div class="feature-icon-large" style="background: rgba(255, 98, 0, 0.1); color: var(--orange);">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="feature-row reveal reveal-delay-3">
                <div class="feature-num">04</div>
                <div class="feature-content">
                    <h2>Tableaux de bord et analytique</h2>
                    <p>Accédez à des dashboards personnalisables avec tous vos KPI RH en temps réel. Suivez le taux de présence, l'absentéisme, le turnover, la masse salariale et bien plus. Générez des rapports détaillés en un clic.</p>
                    <ul class="feature-benefits">
                        <li><i class="fas fa-check"></i> KPI en temps réel</li>
                        <li><i class="fas fa-check"></i> Dashboards personnalisés</li>
                        <li><i class="fas fa-check"></i> Rapports exportables</li>
                        <li><i class="fas fa-check"></i> Graphiques interactifs</li>
                    </ul>
                </div>
                <div class="feature-visual">
                    <div class="feature-icon-large" style="background: rgba(255, 98, 0, 0.1); color: var(--orange);">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
            </div>

            <!-- Feature 5 -->
            <div class="feature-row reveal reveal-delay-1">
                <div class="feature-num">05</div>
                <div class="feature-content">
                    <h2>Gestion des documents</h2>
                    <p>Stockez et gérez tous les documents RH au même endroit. Contrats, certificats, lettres de mission, évaluations — tout est accessible et sécurisé. Générez automatiquement les documents courants.</p>
                    <ul class="feature-benefits">
                        <li><i class="fas fa-check"></i> Stockage sécurisé</li>
                        <li><i class="fas fa-check"></i> Génération de documents</li>
                        <li><i class="fas fa-check"></i> Signature électronique</li>
                        <li><i class="fas fa-check"></i> Historique versionné</li>
                    </ul>
                </div>
                <div class="feature-visual">
                    <div class="feature-icon-large" style="background: rgba(255, 98, 0, 0.1); color: var(--orange);">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>

            <!-- Feature 6 -->
            <div class="feature-row reveal reveal-delay-2">
                <div class="feature-num">06</div>
                <div class="feature-content">
                    <h2>Notifications et alertes</h2>
                    <p>Restez informé de tous les événements RH importants. Renouvellement de contrats, anniversaires, dates limites de formation, demandes de congés en attente — rien n'est oublié.</p>
                    <ul class="feature-benefits">
                        <li><i class="fas fa-check"></i> Alertes personnalisées</li>
                        <li><i class="fas fa-check"></i> Notifications en temps réel</li>
                        <li><i class="fas fa-check"></i> Rappels par email</li>
                        <li><i class="fas fa-check"></i> Calendrier d'événements</li>
                    </ul>
                </div>
                <div class="feature-visual">
                    <div class="feature-icon-large" style="background: rgba(255, 98, 0, 0.1); color: var(--orange);">
                        <i class="fas fa-bell"></i>
                    </div>
                </div>
            </div>

            <!-- Feature 7 -->
            <div class="feature-row reveal reveal-delay-3">
                <div class="feature-num">07</div>
                <div class="feature-content">
                    <h2>Application mobile</h2>
                    <p>Gérez votre RH sur la route. L'application mobile Mania-PME vous donne accès à toutes les fonctionnalités depuis votre smartphone. Validez les demandes, consultez les tableaux de bord, tout, partout.</p>
                    <ul class="feature-benefits">
                        <li><i class="fas fa-check"></i> iOS et Android</li>
                        <li><i class="fas fa-check"></i> Hors ligne</li>
                        <li><i class="fas fa-check"></i> Push notifications</li>
                        <li><i class="fas fa-check"></i> Synchronisation instantanée</li>
                    </ul>
                </div>
                <div class="feature-visual">
                    <div class="feature-icon-large" style="background: rgba(255, 98, 0, 0.1); color: var(--orange);">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                </div>
            </div>

            <!-- Feature 8 -->
            <div class="feature-row reveal reveal-delay-1">
                <div class="feature-num">08</div>
                <div class="feature-content">
                    <h2>Sécurité et conformité</h2>
                    <p>Vos données RH sont précieuses. Nous utilisons le chiffrement de niveau militaire, des sauvegardes automatiques, et respectons toutes les normes de conformité (ISO, RGPD, etc.).</p>
                    <ul class="feature-benefits">
                        <li><i class="fas fa-check"></i> Chiffrement AES-256</li>
                        <li><i class="fas fa-check"></i> Sauvegardes quotidiennes</li>
                        <li><i class="fas fa-check"></i> Conformité RGPD</li>
                        <li><i class="fas fa-check"></i> Audit trail complet</li>
                    </ul>
                </div>
                <div class="feature-visual">
                    <div class="feature-icon-large" style="background: rgba(255, 98, 0, 0.1); color: var(--orange);">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section class="features-cta" style="background: var(--gray); padding: 80px 5%;">
    <div class="container" style="text-align: center;">
        <h2 class="section-title reveal">
            Prêt à essayer ?
        </h2>
        <p class="section-subtitle reveal reveal-delay-1">
            Créez votre espace gratuitement et explorez toutes les fonctionnalités
        </p>
        <a href="{{ route('register') }}" class="btn btn-primary reveal reveal-delay-2">
            <i class="fas fa-rocket"></i>
            Commencer maintenant
        </a>
    </div>
</section> -->

<section class="cta-final">
    <div class="cta-container">
        <div class="cta-background">
            <div class="cta-orb"></div>
            <div class="cta-orb-2"></div>
        </div>
        <div class="cta-content">
            <span class="cta-badge reveal"><i class="fas fa-chart-line"></i> Démarrage immédiat</span>
            <h2 class="cta-title reveal">Rejoignez <span class="gradient-text">des centaines</span> de PME africaines</h2>
            <p class="cta-subtitle reveal reveal-delay-1">La solution RH plébiscitée par les entreprises qui veulent avancer.</p>
            <div class="cta-buttons reveal reveal-delay-2">
                <a href="{{ route('register') }}" class="btn-cta-primary">
                    <i class="fas fa-rocket"></i> Créer mon compte gratuit
                </a>
                <a href="{{ url('/contact') }}" class="btn-cta-secondary">
                    <i class="fas fa-headset"></i> Contacter le support
                </a>
            </div>
            <div class="cta-trust reveal reveal-delay-3">
                <div class="trust-item">
                    <i class="fas fa-calendar-week"></i>
                    <span>14 jours d'essai</span>
                </div>
                <div class="trust-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Aucune carte requise</span>
                </div>
                <div class="trust-item">
                    <i class="fas fa-ban"></i>
                    <span>Annulation libre</span>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .features-hero {
        padding: 120px 5% 80px;
        background: linear-gradient(135deg, rgba(255, 98, 0, 0.05) 0%, rgba(255, 98, 0, 0.02) 100%);
        text-align: center;
    }

    .page-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 52px;
        font-weight: 700;
        margin-bottom: 16px;
        color: var(--black);
    }

    .page-subtitle {
        font-size: 18px;
        color: var(--muted);
        max-width: 600px;
        margin: 0 auto;
    }

    .features-main {
        padding: 80px 5%;
        background: var(--white);
    }

    .features-list {
        max-width: 1200px;
        margin: 0 auto;
    }

    .feature-row {
        display: grid;
        grid-template-columns: auto 1fr 200px;
        gap: 60px;
        align-items: center;
        margin-bottom: 120px;
        padding-bottom: 120px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .feature-row:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .feature-num {
        font-family: 'Clash Display', sans-serif;
        font-size: 48px;
        font-weight: 700;
        color: rgba(255, 98, 0, 0.1);
        line-height: 1;
    }

    .feature-content h2 {
        font-family: 'Clash Display', sans-serif;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 16px;
        color: var(--black);
    }

    .feature-content p {
        font-size: 16px;
        color: var(--muted);
        line-height: 1.8;
        margin-bottom: 24px;
    }

    .feature-benefits {
        list-style: none;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .feature-benefits li {
        font-size: 14px;
        color: var(--black);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .feature-benefits li i {
        color: var(--orange);
        font-size: 12px;
    }

    .feature-visual {
        text-align: center;
    }

    .feature-icon-large {
        width: 160px;
        height: 160px;
        background: linear-gradient(135deg, var(--orange) 0%, #FF8C42 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 64px;
        color: var(--white);
        margin: 0 auto;
    }

    .section-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 16px;
        color: var(--black);
    }

    .section-subtitle {
        font-size: 16px;
        color: var(--muted);
        margin-bottom: 32px;
    }

    .btn-primary {
        background: var(--orange);
        color: var(--white);
        padding: 14px 32px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .btn-primary:hover {
        background: #FF7722;
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(255, 98, 0, 0.3);
    }
     /* CTA Final Section */
    .cta-final {
        padding: 80px 5%;
    }

    .cta-container {
        max-width: 900px;
        margin: 0 auto;
        position: relative;
        background: linear-gradient(135deg, #FF6200 0%, #FF8C42 100%);
        border-radius: 48px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(255, 98, 0, 0.4);
    }

    .cta-background {
        position: absolute;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .cta-orb {
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        top: -100px;
        right: -100px;
        animation: orbFloat 8s ease-in-out infinite;
    }

    .cta-orb-2 {
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        bottom: -60px;
        left: -60px;
        animation: orbFloat 10s ease-in-out infinite reverse;
    }

    @keyframes orbFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(20px, -20px) scale(1.1); }
    }

    .cta-content {
        position: relative;
        z-index: 2;
        padding: 64px 48px;
        text-align: center;
    }

    .cta-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 8px 20px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 600;
        color: var(--white);
        margin-bottom: 24px;
        letter-spacing: 0.5px;
    }

    .cta-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 42px;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .gradient-text {
        background: linear-gradient(135deg, #FFF5EB, #FFE0CC);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .cta-subtitle {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 32px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .cta-buttons {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .btn-cta-primary {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        background: var(--white);
        color: var(--orange);
        border-radius: 60px;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-cta-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
        background: #FFF5EB;
    }

    .btn-cta-secondary {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        color: var(--white);
        border-radius: 60px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-cta-secondary:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-3px);
    }

    .cta-trust {
        display: flex;
        justify-content: center;
        gap: 32px;
        flex-wrap: wrap;
    }

    .trust-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.85);
    }

    .trust-item i {
        font-size: 14px;
    }

    @media (max-width: 900px) {
        .feature-row {
            grid-template-columns: 1fr;
            gap: 32px;
            margin-bottom: 80px;
            padding-bottom: 80px;
        }

        .feature-num {
            font-size: 36px;
        }

        .feature-content h2 {
            font-size: 24px;
        }

        .feature-benefits {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 36px;
        }
    }

    @media (max-width: 600px) {
        .page-title {
            font-size: 28px;
        }

        .feature-content h2 {
            font-size: 20px;
        }

        .feature-content p {
            font-size: 14px;
        }

        .feature-icon-large {
            width: 120px;
            height: 120px;
            font-size: 48px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });
    reveals.forEach(r => observer.observe(r));
</script>
@endpush
