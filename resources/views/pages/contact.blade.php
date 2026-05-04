@extends('layouts.public')
@section('title', 'Nous contacter — Mania-PME')
@section('description', 'Entrez en contact avec notre équipe')
@section('bodyClass', 'page-contact')

@section('content')
<section class="contact-hero" style="background: var(--black); padding: 120px 5% 80px; text-align: center; position: relative; overflow: hidden; isolation: isolate;">
    
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
            <i class="fas fa-headset" style="font-size: 10px;"></i>
            Contact
        </div>

        <h1 class="page-title reveal" style="font-family: 'Clash Display', sans-serif; font-size: 56px; font-weight: 700; margin-bottom: 20px; color: var(--white); line-height: 1.1; letter-spacing: -1px; max-width: 800px; margin-left: auto; margin-right: auto;">
            Nous sommes là<br>
            <span style="color: var(--orange);">pour vous aider</span>
        </h1>
        
        <p class="page-subtitle reveal reveal-delay-1" style="font-size: 18px; color: rgba(255,255,255,0.6); max-width: 550px; margin: 0 auto 32px; line-height: 1.7;">
            Une question ? Une suggestion ? Contactez-nous. Notre équipe répond sous 24h.
        </p>

        {{-- Stats mini --}}
        <!-- <div class="reveal reveal-delay-2" style="display: flex; gap: 40px; justify-content: center; flex-wrap: wrap;">
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">24h</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Réponse</div>
            </div>
            <div style="width: 1px; background: rgba(255,255,255,0.1);"></div>
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">3</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Pays</div>
            </div>
            <div style="width: 1px; background: rgba(255,255,255,0.1);"></div>
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">9h-18h</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Disponibilité</div>
            </div>
        </div> -->
    </div>
</section>
<!-- <section class="contact-hero">
    <div class="container">
        <h1 class="page-title reveal">
            Nous sommes là pour vous aider
        </h1>
        <p class="page-subtitle reveal reveal-delay-1">
            Une question ? Une suggestion ? Contactez-nous. Notre équipe répond sous 24h.
        </p>
    </div>
</section> -->

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Form -->
            <div class="contact-form reveal">
                <h2>Envoyez-nous un message</h2>
                <form onsubmit="handleSubmit(event)">
                    <div class="form-group">
                        <label>Nom complet <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="name" placeholder="Jean Dupont" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" placeholder="jean@example.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Entreprise</label>
                        <div class="input-wrapper">
                            <i class="fas fa-building input-icon"></i>
                            <input type="text" name="company" placeholder="Tech Solutions SARL">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Sujet <span class="required">*</span></label>
                        <select name="subject" required>
                            <option value="">Choisissez un sujet...</option>
                            <option value="support">Support technique</option>
                            <option value="sales">Information commerciale</option>
                            <option value="partnership">Partenariat</option>
                            <option value="feedback">Retour client</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Message <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-comment input-icon textarea-icon"></i>
                            <textarea name="message" rows="6" placeholder="Votre message ici..." required></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Envoyer le message
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="contact-info">
                <div class="info-block reveal reveal-delay-1">
                    <div class="info-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Support technique</h3>
                    <p>Questions sur Mania-PME ? Notre équipe support est disponible pour vous aider.</p>
                    <a href="mailto:support@mania-pme.com" class="info-link">
                        support@mania-pme.com
                    </a>
                    <p class="info-time">Réponse sous 24h</p>
                </div>

                <div class="info-block reveal reveal-delay-2">
                    <div class="info-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3>Ventes et partenariats</h3>
                    <p>Intéressé par nos solutions pour votre entreprise ? Parlons-en !</p>
                    <a href="mailto:sales@mania-pme.com" class="info-link">
                        sales@mania-pme.com
                    </a>
                    <p class="info-time">Réponse rapide</p>
                </div>

                <div class="info-block reveal reveal-delay-3">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Où nous trouver</h3>
                    <p>Nous opérons depuis l'Afrique de l'Ouest.</p>
                    <p>Cotonou, Bénin • Dakar, Sénégal • Abidjan, Côte d'Ivoire</p>
                </div>

                <div class="info-block reveal reveal-delay-1">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Horaires</h3>
                    <p>Nous sommes disponibles du lundi au vendredi</p>
                    <p><strong>9h - 18h</strong> heure d'Afrique de l'Ouest</p>
                </div>

                <div class="info-block reveal reveal-delay-2">
                    <div class="info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Téléphone</h3>
                    <p>Appelez-nous directement pour une conversation rapide</p>
                    <a href="tel:+22912345678" class="info-link">
                        +229 1234 5678
                    </a>
                </div>

                <div class="info-block reveal reveal-delay-3">
                    <div class="info-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Réseaux sociaux</h3>
                    <p>Suivez-nous pour les dernières actualités et mises à jour</p>
                    <div class="social-links">
                        <a href="https://linkedin.com" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://twitter.com" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://facebook.com" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://instagram.com" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="faq-quick" style="background: var(--gray); padding: 80px 5%;">
    <div class="container">
        <h2 class="section-title reveal">
            Questions rapides
        </h2>
        <p class="section-subtitle reveal reveal-delay-1">
            Vous trouverez peut-être votre réponse ici
        </p>

        <div class="faq-quick-grid">
            <div class="faq-quick-item reveal reveal-delay-1">
                <h3><i class="fas fa-question-circle"></i> Comment puis-je me facturer ?</h3>
                <p>Vous pouvez ajouter votre méthode de paiement dans les paramètres du compte. Nous acceptons les cartes bancaires, virements et portefeuilles mobiles.</p>
            </div>

            <div class="faq-quick-item reveal reveal-delay-2">
                <h3><i class="fas fa-question-circle"></i> Vos données sont-elles sécurisées ?</h3>
                <p>Oui, nous utilisons le chiffrement AES-256 et toutes les meilleures pratiques de sécurité. Votre conformité RGPD est garantie.</p>
            </div>

            <div class="faq-quick-item reveal reveal-delay-3">
                <h3><i class="fas fa-question-circle"></i> Proposez-vous une période d'essai ?</h3>
                <p>Oui, 14 jours gratuits sans engagement. Explorez toutes les fonctionnalités. Aucune carte bancaire requise.</p>
            </div>

            <div class="faq-quick-item reveal reveal-delay-1">
                <h3><i class="fas fa-question-circle"></i> Puis-je annuler ma souscription ?</h3>
                <p>Oui, à tout moment. Vous conserverez l'accès jusqu'à la fin de votre période de facturation. Pas de pénalité.</p>
            </div>

            <div class="faq-quick-item reveal reveal-delay-2">
                <h3><i class="fas fa-question-circle"></i> Offrez-vous une formation ?</h3>
                <p>Oui, notre équipe peut vous former à l'utilisation de la plateforme. Une documentation complète est également disponible.</p>
            </div>

            <div class="faq-quick-item reveal reveal-delay-3">
                <h3><i class="fas fa-question-circle"></i> Comment importer mes données RH ?</h3>
                <p>Vous pouvez importer vos données via CSV ou nous contacter pour une migration assistée. C'est simple et rapide.</p>
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

<!-- <section class="cta-contact" style="background: linear-gradient(135deg, var(--orange) 0%, #FF8C42 100%); padding: 80px 5%; color: var(--white); text-align: center;">
    <h2 class="section-title reveal" style="color: var(--white); margin-bottom: 16px;">
        Prêt à commencer ?
    </h2>
    <p class="section-subtitle reveal reveal-delay-1" style="color: rgba(255, 255, 255, 0.95);">
        Créez un compte gratuit maintenant et testez Mania-PME sans engagement
    </p>
    <a href="{{ route('register') }}" class="btn btn-white reveal reveal-delay-2">
        <i class="fas fa-rocket"></i> Démarrer mon essai gratuit
    </a>
</section> -->

@endsection

@push('styles')
<style>
    .contact-hero {
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

    .contact-section {
        padding: 80px 5%;
        background: var(--white);
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: start;
    }

    .contact-form h2 {
        font-family: 'Clash Display', sans-serif;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 32px;
        color: var(--black);
    }

    .form-group {
        margin-bottom: 24px;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--black);
        font-size: 14px;
    }

    .required {
        color: var(--orange);
    }

    .input-wrapper {
        position: relative;
    }

    input[type="text"],
    input[type="email"],
    select,
    textarea {
        width: 100%;
        padding: 12px 14px 12px 42px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Cabinet Grotesk', sans-serif;
        transition: all 0.3s ease;
        background: var(--white);
        color: var(--black);
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: var(--orange);
        box-shadow: 0 0 0 3px rgba(255, 98, 0, 0.1);
    }

    select {
        cursor: pointer;
        appearance: none;
        padding-right: 40px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23FF6200' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--orange);
        font-size: 14px;
        pointer-events: none;
        z-index: 2;
    }

    .textarea-icon {
        top: 14px;
        transform: none;
    }

    textarea {
        resize: vertical;
        padding-top: 12px;
    }

    .btn {
        width: 100%;
        padding: 14px 32px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        cursor: pointer;
    }

    .btn-primary {
        background: var(--orange);
        color: var(--white);
    }

    .btn-primary:hover {
        background: #FF7722;
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(255, 98, 0, 0.3);
    }

    .contact-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .info-block {
        background: var(--gray);
        padding: 32px;
        border-radius: 12px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    .info-icon {
        font-size: 40px;
        color: var(--orange);
        margin-bottom: 16px;
    }

    .info-block h3 {
        font-family: 'Clash Display', sans-serif;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--black);
    }

    .info-block p {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .info-link {
        color: var(--orange);
        font-weight: 600;
        text-decoration: none;
        display: block;
        margin-bottom: 8px;
    }

    .info-link:hover {
        text-decoration: underline;
    }

    .info-time {
        font-size: 12px !important;
        color: #999 !important;
        margin-bottom: 0 !important;
    }

    .social-links {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 16px;
    }

    .social-links a {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1px solid var(--orange);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--orange);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .social-links a:hover {
        background: var(--orange);
        color: var(--white);
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

    .faq-quick-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 32px;
    }

    .faq-quick-item {
        background: var(--white);
        padding: 32px;
        border-radius: 12px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .faq-quick-item h3 {
        font-family: 'Clash Display', sans-serif;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--black);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .faq-quick-item h3 i {
        color: var(--orange);
    }

    .faq-quick-item p {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.6;
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
        .contact-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .contact-info {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 36px;
        }
    }

    @media (max-width: 600px) {
        select {
            background-position: right 10px center;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            padding: 12px 10px 12px 40px;
        }

        .input-icon {
            left: 10px;
            font-size: 12px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function handleSubmit(event) {
        event.preventDefault();
        alert('Merci ! Votre message a été envoyé. Notre équipe vous répondra dans les 24h.');
        event.target.reset();
    }

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
