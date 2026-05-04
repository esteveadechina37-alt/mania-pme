@extends('layouts.public')
@section('title', 'Tarifs — Mania-PME')
@section('description', 'Plans tarifaires simples et transparents pour gérer vos RH')
@section('bodyClass', 'page-tarifs')

@section('content')
<section class="pricing-hero" style="background: var(--black); padding: 120px 5% 80px; text-align: center; position: relative; overflow: hidden; isolation: isolate;">
    
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
            <i class="fas fa-tags" style="font-size: 10px;"></i>
            Tarifs
        </div>

        <h1 class="page-title reveal" style="font-family: 'Clash Display', sans-serif; font-size: 56px; font-weight: 700; margin-bottom: 20px; color: var(--white); line-height: 1.1; letter-spacing: -1px; max-width: 800px; margin-left: auto; margin-right: auto;">
            Des tarifs<br>
            <span style="color: var(--orange);">simples et transparents</span>
        </h1>
        
        <p class="page-subtitle reveal reveal-delay-1" style="font-size: 18px; color: rgba(255,255,255,0.6); max-width: 550px; margin: 0 auto 32px; line-height: 1.7;">
            Pas de frais cachés. Pas d'engagement. Annulez quand vous voulez. Choisissez le plan qui correspond à votre entreprise.
        </p>

        {{-- Stats mini --}}
        <!-- <div class="reveal reveal-delay-2" style="display: flex; gap: 40px; justify-content: center; flex-wrap: wrap;">
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">14j</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Essai gratuit</div>
            </div>
            <div style="width: 1px; background: rgba(255,255,255,0.1);"></div>
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">0 FCFA</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Carte requise</div>
            </div>
            <div style="width: 1px; background: rgba(255,255,255,0.1);"></div>
            <div style="text-align: center;">
                <div style="font-family: 'Clash Display', sans-serif; font-size: 32px; font-weight: 700; color: var(--orange);">-20%</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Paiement annuel</div>
            </div>
        </div> -->
    </div>
</section>
<!-- <section class="pricing-hero">
    <div class="container">
        <h1 class="page-title reveal">
            Tarifs simples et transparents
        </h1>
        <p class="page-subtitle reveal reveal-delay-1">
            Pas de frais cachés. Pas d'engagement. Annulez quand vous voulez.
        </p>
    </div>
</section> -->

<section class="pricing-section">
    <div class="container">
        <div class="pricing-toggle">
            <span class="toggle-label">Mensuel</span>
            <button class="toggle-switch" onclick="togglePricing()"></button>
            <span class="toggle-label">Annuel <span class="save-badge">-20%</span></span>
        </div>

        <div class="pricing-grid">
            <!-- Plan Starter -->
            <div class="pricing-card reveal">
                <div class="card-header">
                    <h3>Starter</h3>
                    <p class="card-desc">Pour tester</p>
                </div>

                <div class="pricing-box">
                    <div class="price-monthly">
                        <span class="amount">0 FCFA</span>
                        <span class="period">/mois</span>
                    </div>
                    <div class="price-annual" style="display:none;">
                        <span class="amount">0 FCFA</span>
                        <span class="period">/an</span>
                    </div>
                </div>

                <ul class="pricing-features">
                    <li class="included"><i class="fas fa-check-circle"></i> Jusqu'à 10 collaborateurs</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Gestion d'équipe basique</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Calendrier des congés</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Support par email</li>
                    <li class="not-included"><i class="fas fa-times-circle"></i> Paie automatique</li>
                    <li class="not-included"><i class="fas fa-times-circle"></i> Tableaux de bord avancés</li>
                    <li class="not-included"><i class="fas fa-times-circle"></i> API</li>
                </ul>

                <a href="{{ route('register') }}" class="btn btn-outline">
                    Commencer gratuitement
                </a>
            </div>

            <!-- Plan Pro -->
            <div class="pricing-card featured reveal reveal-delay-1">
                <div class="badge-popular">Populaire</div>
                <div class="card-header">
                    <h3>Pro</h3>
                    <p class="card-desc">Pour croître</p>
                </div>

                <div class="pricing-box">
                    <div class="price-monthly">
                        <span class="amount">4,999 FCFA</span>
                        <span class="period">/mois</span>
                    </div>
                    <div class="price-annual" style="display:none;">
                        <span class="amount">47,990 FCFA</span>
                        <span class="period">/an</span>
                        <span class="saving">Économisez 12,000 FCFA</span>
                    </div>
                </div>

                <ul class="pricing-features">
                    <li class="included"><i class="fas fa-check-circle"></i> Jusqu'à 100 collaborateurs</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Gestion d'équipe complète</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Paie automatique</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Tableaux de bord avancés</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Suivi des présences</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Documents générés</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Support prioritaire</li>
                </ul>

                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-rocket"></i> Commencer maintenant
                </a>
            </div>

            <!-- Plan Enterprise -->
            <div class="pricing-card reveal reveal-delay-2">
                <div class="card-header">
                    <h3>Enterprise</h3>
                    <p class="card-desc">Solutions personnalisées</p>
                </div>

                <div class="pricing-box">
                    <div class="price-monthly">
                        <span class="amount">Devis</span>
                        <span class="period">sur demande</span>
                    </div>
                </div>

                <ul class="pricing-features">
                    <li class="included"><i class="fas fa-check-circle"></i> Collaborateurs illimités</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Toutes les fonctionnalités</li>
                    <li class="included"><i class="fas fa-check-circle"></i> API complète</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Intégrations personnalisées</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Onboarding dédié</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Support 24/7</li>
                    <li class="included"><i class="fas fa-check-circle"></i> Infrastructure dédiée</li>
                </ul>

                <a href="{{ url('/contact') }}" class="btn btn-outline">
                    Nous contacter
                </a>
            </div>
        </div>
    </div>
</section>

<section class="comparison-section">
    <div class="container">
        <h2 class="section-title reveal">
            Comparaison détaillée des plans
        </h2>

        <div class="comparison-table reveal reveal-delay-1">
            <table>
                <thead>
                    <tr>
                        <th>Fonctionnalités</th>
                        <th>Starter</th>
                        <th>Pro</th>
                        <th>Enterprise</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nombre de collaborateurs</td>
                        <td>Jusqu'à 10</td>
                        <td>Jusqu'à 100</td>
                        <td>Illimité</td>
                    </tr>
                    <tr>
                        <td>Gestion d'équipe</td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                    </tr>
                    <tr>
                        <td>Congés et absences</td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                    </tr>
                    <tr>
                        <td>Paie et bulletins</td>
                        <td><i class="fas fa-times-circle" style="color:#ddd"></i></td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                    </tr>
                    <tr>
                        <td>Tableaux de bord</td>
                        <td>Basiques</td>
                        <td>Avancés</td>
                        <td>Personnalisés</td>
                    </tr>
                    <tr>
                        <td>Suivi des présences</td>
                        <td><i class="fas fa-times-circle" style="color:#ddd"></i></td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                    </tr>
                    <tr>
                        <td>Gestion des documents</td>
                        <td><i class="fas fa-times-circle" style="color:#ddd"></i></td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                    </tr>
                    <tr>
                        <td>API</td>
                        <td><i class="fas fa-times-circle" style="color:#ddd"></i></td>
                        <td><i class="fas fa-times-circle" style="color:#ddd"></i></td>
                        <td><i class="fas fa-check-circle" style="color:var(--orange)"></i></td>
                    </tr>
                    <tr>
                        <td>Support</td>
                        <td>Email</td>
                        <td>Prioritaire</td>
                        <td>24/7 Dédié</td>
                    </tr>
                    <tr>
                        <td>Garantie d'uptime</td>
                        <td>99%</td>
                        <td>99.5%</td>
                        <td>99.9%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <h2 class="section-title reveal">
            Questions fréquentes
        </h2>

        <div class="faq-grid">
            <div class="faq-item reveal reveal-delay-1">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <i class="fas fa-chevron-down faq-icon"></i>
                    <span>Puis-je changer de plan à tout moment ?</span>
                </div>
                <div class="faq-answer">
                    <p>Oui, vous pouvez modifier votre plan à tout moment depuis votre espace client. Si vous passez à un plan supérieur, le changement est immédiat. Si vous passez à un plan inférieur, il prend effet au prochain cycle de facturation. Aucun frais supplémentaire n'est appliqué.</p>
                </div>
            </div>

            <div class="faq-item reveal reveal-delay-2">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <i class="fas fa-chevron-down faq-icon"></i>
                    <span>Quels modes de paiement acceptez-vous ?</span>
                </div>
                <div class="faq-answer">
                    <p>Nous acceptons les cartes bancaires (Visa, Mastercard), les virements bancaires, et les portefeuilles mobiles (MTN Money, Orange Money, Wave). Tous les paiements sont sécurisés par chiffrement SSL.</p>
                </div>
            </div>

            <div class="faq-item reveal reveal-delay-3">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <i class="fas fa-chevron-down faq-icon"></i>
                    <span>Existe-t-il une période d'essai gratuite ?</span>
                </div>
                <div class="faq-answer">
                    <p>Oui, tous nos plans commencent par <strong>14 jours gratuits</strong>. Aucune carte bancaire n'est requise pour l'essai. Vous pouvez explorer toutes les fonctionnalités sans limitation et décider ensuite du plan qui vous convient.</p>
                </div>
            </div>

            <div class="faq-item reveal reveal-delay-1">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <i class="fas fa-chevron-down faq-icon"></i>
                    <span>Que se passe-t-il si je dépasse ma limite de collaborateurs ?</span>
                </div>
                <div class="faq-answer">
                    <p>Vous serez notifié par email avant d'atteindre votre limite. Vous pourrez alors facilement passer à un plan supérieur ou ajouter des collaborateurs supplémentaires à votre plan actuel. L'ajout est proratisé selon le temps restant dans votre cycle.</p>
                </div>
            </div>

            <div class="faq-item reveal reveal-delay-2">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <i class="fas fa-chevron-down faq-icon"></i>
                    <span>Offrez-vous des réductions pour les organisations sans but lucratif ?</span>
                </div>
                <div class="faq-answer">
                    <p>Oui, nous offrons <strong>-30%</strong> aux organisations sans but lucratif et aux établissements d'enseignement. <a href="{{ url('/contact') }}">Contactez notre équipe</a> avec votre justificatif pour bénéficier de ce tarif préférentiel.</p>
                </div>
            </div>

            <div class="faq-item reveal reveal-delay-3">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <i class="fas fa-chevron-down faq-icon"></i>
                    <span>Puis-je annuler mon abonnement à tout moment ?</span>
                </div>
                <div class="faq-answer">
                    <p>Oui, vous pouvez annuler à tout moment sans pénalité depuis votre espace client. Vous conserverez l'accès à toutes les fonctionnalités jusqu'à la fin de votre période de facturation en cours.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final Section -->
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
    :root {
        --orange: #FF6200;
        --white: #ffffff;
        --black: #0A0A0A;
        --gray: #F5F5F5;
        --muted: #666666;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .pricing-hero {
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

    .pricing-section {
        padding: 80px 5%;
        background: var(--white);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .pricing-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        margin-bottom: 60px;
    }

    .toggle-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--black);
    }

    .save-badge {
        background: var(--orange);
        color: var(--white);
        padding: 2px 8px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 700;
        margin-left: 8px;
    }

    .toggle-switch {
        width: 50px;
        height: 28px;
        background: var(--gray);
        border: none;
        border-radius: 100px;
        cursor: pointer;
        position: relative;
        transition: background 0.3s ease;
    }

    .toggle-switch::after {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        background: var(--white);
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: left 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .toggle-switch.active {
        background: var(--orange);
    }

    .toggle-switch.active::after {
        left: 24px;
    }

    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 32px;
        margin-bottom: 60px;
    }

    .pricing-card {
        background: var(--white);
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 24px;
        padding: 40px 32px;
        position: relative;
        transition: all 0.3s ease;
    }

    .pricing-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
    }

    .pricing-card.featured {
        border-color: var(--orange);
        transform: scale(1.05);
        box-shadow: 0 20px 50px rgba(255, 98, 0, 0.2);
    }

    .badge-popular {
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
        text-transform: uppercase;
    }

    .card-header {
        margin-bottom: 24px;
    }

    .card-header h3 {
        font-family: 'Clash Display', sans-serif;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .card-desc {
        font-size: 13px;
        color: var(--muted);
    }

    .pricing-box {
        padding: 24px 0;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .amount {
        font-family: 'Clash Display', sans-serif;
        font-size: 36px;
        font-weight: 700;
        color: var(--orange);
        display: block;
    }

    .period {
        font-size: 14px;
        color: var(--muted);
        display: block;
        margin-top: 4px;
    }

    .saving {
        display: block;
        font-size: 12px;
        color: #4ade80;
        margin-top: 8px;
        font-weight: 600;
    }

    .pricing-features {
        list-style: none;
        margin-bottom: 24px;
    }

    .pricing-features li {
        font-size: 13px;
        color: var(--black);
        padding: 10px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.03);
    }

    .pricing-features li.included i {
        color: var(--orange);
        font-size: 14px;
    }

    .pricing-features li.not-included {
        color: var(--muted);
    }

    .pricing-features li.not-included i {
        color: #ddd;
    }

    .btn {
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        width: 100%;
        cursor: pointer;
        text-decoration: none;
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

    .btn-outline {
        background: transparent;
        color: var(--black);
        border-color: var(--black);
    }

    .btn-outline:hover {
        background: var(--black);
        color: var(--white);
    }

    .comparison-section {
        background: var(--gray);
        padding: 80px 5%;
    }

    .comparison-table {
        overflow-x: auto;
        border-radius: 20px;
        background: var(--white);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 20px;
        overflow: hidden;
    }

    th {
        background: rgba(0, 0, 0, 0.03);
        padding: 18px 16px;
        text-align: left;
        font-weight: 700;
        font-size: 14px;
        color: var(--black);
        border-bottom: 2px solid rgba(0, 0, 0, 0.08);
    }

    td {
        padding: 16px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 14px;
        color: var(--muted);
    }

    td:first-child {
        font-weight: 600;
        color: var(--black);
    }

    tr:last-child td {
        border-bottom: none;
    }

    /* FAQ Section */
    .faq-section {
        padding: 80px 5%;
        background: var(--white);
    }

    .section-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 48px;
        color: var(--black);
        text-align: center;
    }

    .faq-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 24px;
    }

    .faq-item {
        background: var(--white);
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        border-color: var(--orange);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    }

    .faq-question {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 22px 24px;
        background: var(--white);
        cursor: pointer;
        transition: background 0.3s ease;
        width: 100%;
        text-align: left;
    }

    .faq-question:hover {
        background: rgba(255, 98, 0, 0.03);
    }

    .faq-question .faq-icon {
        color: var(--orange);
        font-size: 14px;
        transition: transform 0.3s ease;
        flex-shrink: 0;
    }

    .faq-question span {
        font-family: 'Clash Display', sans-serif;
        font-size: 16px;
        font-weight: 600;
        color: var(--black);
    }

    .faq-question.active .faq-icon {
        transform: rotate(180deg);
    }

    .faq-answer {
        display: none;
        padding: 0 24px 24px 24px;
        background: var(--white);
        font-size: 14px;
        color: var(--muted);
        line-height: 1.7;
    }

    .faq-answer.active {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .faq-answer p {
        margin: 0;
    }

    .faq-answer strong {
        color: var(--orange);
    }

    .faq-answer a {
        color: var(--orange);
        text-decoration: none;
        font-weight: 600;
    }

    .faq-answer a:hover {
        text-decoration: underline;
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

    /* Reveal Animations */
    .reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease;
    }

    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .reveal-delay-1 { transition-delay: 0.1s; }
    .reveal-delay-2 { transition-delay: 0.2s; }
    .reveal-delay-3 { transition-delay: 0.3s; }

    @media (max-width: 768px) {
        .page-title { font-size: 32px; }
        .section-title { font-size: 32px; }
        .cta-title { font-size: 28px; }
        .cta-content { padding: 48px 24px; }
        .faq-grid { grid-template-columns: 1fr; }
        .pricing-card.featured { transform: scale(1); }
        .cta-buttons { flex-direction: column; align-items: center; }
        .btn-cta-primary, .btn-cta-secondary { width: 100%; justify-content: center; }
    }
</style>
@endpush

@push('scripts')
<script>
    function togglePricing() {
        var monthlyPrices = document.querySelectorAll('.price-monthly');
        var annualPrices = document.querySelectorAll('.price-annual');
        var button = document.querySelector('.toggle-switch');

        for (var i = 0; i < monthlyPrices.length; i++) {
            if (monthlyPrices[i].style.display === 'none') {
                monthlyPrices[i].style.display = 'block';
            } else {
                monthlyPrices[i].style.display = 'none';
            }
        }

        for (var i = 0; i < annualPrices.length; i++) {
            if (annualPrices[i].style.display === 'none') {
                annualPrices[i].style.display = 'block';
            } else {
                annualPrices[i].style.display = 'none';
            }
        }

        button.classList.toggle('active');
    }

    function toggleFaq(element) {
        // Récupérer le parent .faq-item
        var faqItem = element.parentElement;
        while (faqItem && !faqItem.classList.contains('faq-item')) {
            faqItem = faqItem.parentElement;
        }
        
        if (faqItem) {
            var answer = faqItem.querySelector('.faq-answer');
            var icon = element.querySelector('.faq-icon');
            
            if (answer) {
                answer.classList.toggle('active');
                element.classList.toggle('active');
            }
        }
    }

    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page chargée - FAQ fonctionnelle');
    });

    // Reveal animations
    var reveals = document.querySelectorAll('.reveal');
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });
    
    for (var i = 0; i < reveals.length; i++) {
        observer.observe(reveals[i]);
    }
</script>
@endpush