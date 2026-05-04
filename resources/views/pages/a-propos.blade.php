@extends('layouts.public')
@section('title', 'À propos de Mania-PME')
@section('description', 'Découvrez l\'histoire et la mission de Mania-PME')
@section('bodyClass', 'page-about')

@section('content')
<!-- <section class="about-hero">
    <div class="container">
        <h1 class="page-title reveal">
            Notre mission : simplifier les RH en Afrique
        </h1>
        <p class="page-subtitle reveal reveal-delay-1">
            Mania-PME est née d'un constat simple : les PME africaines méritent mieux que des outils complexes conçus ailleurs.
        </p>
    </div>
</section> -->

<section class="about-hero" style="background: var(--black); padding: 120px 5% 80px; text-align: center; position: relative; overflow: hidden; isolation: isolate;">
    
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
            <span style="width: 6px; height: 6px; background: var(--orange); border-radius: 50%; animation: pulse 2s ease-in-out infinite;"></span>
            Notre mission
        </div>

        <h1 class="page-title reveal" style="font-family: 'Clash Display', sans-serif; font-size: 56px; font-weight: 700; margin-bottom: 20px; color: var(--white); line-height: 1.1; letter-spacing: -1px; max-width: 800px; margin-left: auto; margin-right: auto;">
            Simplifier les RH<br>
            <span style="color: var(--orange);">en Afrique</span>
        </h1>
        
        <p class="page-subtitle reveal reveal-delay-1" style="font-size: 18px; color: rgba(255,255,255,0.6); max-width: 550px; margin: 0 auto 32px; line-height: 1.7;">
            Mania-PME est née d'un constat simple : les PME africaines méritent mieux que des outils complexes conçus ailleurs.
        </p>

        {{-- Stats mini --}}
        <!-- <div class="reveal reveal-delay-2" style="display: flex; gap: 40px; justify-content: center; flex-wrap: wrap;">
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">2023</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Fondation</div>
            </div>
            <div style="width: 1px; background: rgba(255,255,255,0.1);"></div>
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">+50</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">PME clientes</div>
            </div>
            <div style="width: 1px; background: rgba(255,255,255,0.1);"></div>
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">5</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Pays</div>
            </div>
        </div> -->
    </div>
</section>

<section class="about-story">
    <div class="container">
        <div class="story-grid">
            <div class="story-block reveal">
                <h2>Notre histoire</h2>
                <p>Mania-PME a été fondée en 2023 par une équipe de développeurs et de RH passionnés par l'Afrique. Après avoir travaillé dans plusieurs PME du continent, nous avons remarqué un problème récurrent : les outils RH existants étaient soit trop chers, soit trop complexes, soit inadaptés aux contextes africains.</p>
                <p>Nous avons décidé de créer une solution spécialement pensée pour les PME africaines. Une plateforme simple à utiliser, abordable financièrement, et respectueuse des spécificités des ressources humaines en Afrique.</p>
            </div>

            <div class="story-block reveal reveal-delay-1">
                <h2>Notre vision</h2>
                <p>Nous rêvons d'un monde où chaque PME africaine, peu importe sa taille, peut gérer efficacement ses ressources humaines. Où les gestionnaires RH peuvent se concentrer sur le développement des talents plutôt que sur l'administratif. Où les données RH sont sécurisées et accessibles partout.</p>
                <p>Mania-PME est notre contribution pour construire ce monde, ensemble.</p>
            </div>

            <div class="story-block reveal reveal-delay-2">
                <h2>Nos valeurs</h2>
                <ul class="values-list">
                    <li><strong>Simplicité</strong> — Les outils complexes n'aident personne</li>
                    <li><strong>Accessibilité</strong> — Les bonnes solutions ne doivent pas coûter une fortune</li>
                    <li><strong>Transparence</strong> — Pas de frais cachés, pas de surprise</li>
                    <li><strong>Sécurité</strong> — Vos données RH sont précieuses et nous les protégeons</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="team-section" style="background: var(--gray); padding: 80px 5%;">
    <div class="container">
        <h2 class="section-title reveal">
            Nos équipes
        </h2>
        <p class="section-subtitle reveal reveal-delay-1">
            Une équipe internationale passionnée par l'innovation RH
        </p>

        <div class="team-grid">
            <div class="team-member reveal reveal-delay-1">
                <div class="member-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h3>Adjobi Kossou</h3>
                <p class="role">Co-fondateur & CEO</p>
                <p class="bio">Ancien DRH avec 10 ans d'expérience dans les PME africaines. Passionné par l'automatisation et l'efficacité.</p>
            </div>

            <div class="team-member reveal reveal-delay-2">
                <div class="member-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h3>Mariam Ndiaye</h3>
                <p class="role">Co-fondatrice & CTO</p>
                <p class="bio">Ingénieure Full Stack avec expertise en sécurité. Obsédée par la qualité du code et l'UX.</p>
            </div>

            <div class="team-member reveal reveal-delay-3">
                <div class="member-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h3>Kwame Asante</h3>
                <p class="role">Head of Support</p>
                <p class="bio">Passionné par la satisfaction client. Répond à toutes les questions et aide les clients à réussir.</p>
            </div>

            <!-- <div class="team-member reveal reveal-delay-1">
                <div class="member-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h3>Amara Traore</h3>
                <p class="role">Product Manager</p>
                <p class="bio">Responsable de la vision produit. Veille à ce que Mania-PME réponde aux vrais besoins.</p>
            </div>

            <div class="team-member reveal reveal-delay-2">
                <div class="member-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h3>Fatou Ba</h3>
                <p class="role">Community Lead</p>
                <p class="bio">Construit une communauté formidable autour de Mania-PME. Toujours disponible pour discuter RH.</p>
            </div> -->

            <div class="team-member reveal reveal-delay-3">
                <div class="member-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h3>Jean-Paul Tano</h3>
                <p class="role">Senior Developer</p>
                <p class="bio">Expert en architecture logicielle. Veille à ce que Mania-PME soit rapide et fiable.</p>
            </div>
        </div>
    </div>
</section>

<section class="values-visual">
    <div class="container">
        <h2 class="section-title reveal">
            Pourquoi choisir Mania-PME ?
        </h2>

        <div class="benefits-grid">
            <div class="benefit-item reveal reveal-delay-1">
                <div class="benefit-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Rapide à mettre en place</h3>
                <p>Créez votre espace en 2 minutes, invitez votre équipe et commencez immédiatement. Pas de configuration complexe.</p>
            </div>

            <div class="benefit-item reveal reveal-delay-2">
                <div class="benefit-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Accessible partout</h3>
                <p>Web, iOS, Android — gérez votre RH depuis n'importe quel appareil, n'importe quand, même hors ligne.</p>
            </div>

            <div class="benefit-item reveal reveal-delay-3">
                <div class="benefit-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Support réactif</h3>
                <p>Une équipe prête à vous aider. Pas de robots, pas de temps d'attente infini. Des humains bienveillants.</p>
            </div>

            <div class="benefit-item reveal reveal-delay-1">
                <div class="benefit-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Évolutif</h3>
                <p>De 5 à 5,000 employés — Mania-PME grandit avec vous sans ralentir ni vous facturer plus.</p>
            </div>

            <div class="benefit-item reveal reveal-delay-2">
                <div class="benefit-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3>Sécurisé</h3>
                <p>Chiffrement militaire, sauvegardes automatiques, conformité RGPD. Vos données sont en sûreté.</p>
            </div>

            <div class="benefit-item reveal reveal-delay-3">
                <div class="benefit-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Conçu localement</h3>
                <p>Par des Africains, pour des Africains. Nous comprenons vos défis et vos contextes spécifiques.</p>
            </div>
        </div>
    </div>
</section>

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

<!-- <section class="cta-about" style="background: linear-gradient(135deg, var(--orange) 0%, #FF8C42 100%); padding: 80px 5%; color: var(--white); text-align: center;">
    <h2 class="section-title reveal" style="color: var(--white); margin-bottom: 16px;">
        Rejoignez-nous !
    </h2>
    <p class="section-subtitle reveal reveal-delay-1" style="color: rgba(255, 255, 255, 0.95); margin-bottom: 32px;">
        Commencez votre essai gratuit dès aujourd'hui et découvrez comment Mania-PME peut transformer votre gestion RH
    </p>
    <a href="{{ route('register') }}" class="btn btn-white reveal reveal-delay-2">
        <i class="fas fa-rocket"></i> Créer mon compte gratuit
    </a>
</section> -->

@endsection

@push('styles')
<style>
    .about-hero {
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

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .about-story {
        padding: 80px 5%;
        background: var(--white);
    }

    .story-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 48px;
    }

    .story-block h2 {
        font-family: 'Clash Display', sans-serif;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 16px;
        color: var(--black);
    }

    .story-block p {
        font-size: 15px;
        color: var(--muted);
        line-height: 1.8;
        margin-bottom: 16px;
    }

    .values-list {
        list-style: none;
    }

    .values-list li {
        font-size: 15px;
        color: var(--muted);
        padding: 12px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .values-list strong {
        color: var(--orange);
        font-weight: 700;
    }

    .section-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 16px;
        color: var(--black);
        text-align: center;
    }

    .section-subtitle {
        font-size: 16px;
        color: var(--muted);
        text-align: center;
        margin-bottom: 48px;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 32px;
    }

    .team-member {
        background: var(--white);
        padding: 32px;
        border-radius: 12px;
        text-align: center;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .team-member:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .member-avatar {
        font-size: 80px;
        color: var(--orange);
        margin-bottom: 16px;
    }

    .team-member h3 {
        font-family: 'Clash Display', sans-serif;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 4px;
        color: var(--black);
    }

    .role {
        font-weight: 600;
        color: var(--orange);
        margin-bottom: 12px !important;
    }

    .bio {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.6;
    }

    .values-visual {
        padding: 80px 5%;
        background: var(--white);
    }

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 32px;
    }

    .benefit-item {
        background: var(--gray);
        padding: 32px;
        border-radius: 12px;
        text-align: center;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .benefit-icon {
        font-size: 40px;
        color: var(--orange);
        margin-bottom: 16px;
        display: block;
    }

    .benefit-item h3 {
        font-family: 'Clash Display', sans-serif;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--black);
    }

    .benefit-item p {
        font-size: 14px;
        color: var(--muted);
        line-height: 1.6;
    }

    .btn {
        padding: 14px 32px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        cursor: pointer;
    }

    .btn-white {
        background: var(--white);
        color: var(--orange);
    }

    .btn-white:hover {
        background: rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
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
        .page-title {
            font-size: 36px;
        }

        .story-grid {
            gap: 32px;
        }

        .team-grid {
            grid-template-columns: 1fr;
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
