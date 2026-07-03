<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clinique IIBS – Accueil</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        :root {
            --med-blue: #3B82B5;
            --med-teal: #5EA8A7;
            --med-mint: #E8F4F8;
            --med-white: #FAFDFF;
            --med-dark: #1A3C4A;
            --med-sand: #FDF6F0;
            --med-glow: #7EC8E3;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--med-white);
            color: var(--med-dark);
            overflow-x: hidden;
            line-height: 1.7;
        }

        /* Animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes breathe {
            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(60px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulseGlow {
            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(62, 130, 181, 0.4);
            }
            50% {
                box-shadow: 0 0 0 25px rgba(62, 130, 181, 0);
            }
        }

        @keyframes crossMove {
            0% {
                transform: rotate(0deg) scale(1);
            }
            25% {
                transform: rotate(3deg) scale(1.02);
            }
            75% {
                transform: rotate(-3deg) scale(0.98);
            }
            100% {
                transform: rotate(0deg) scale(1);
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.8s ease-out forwards;
        }
        .animate-fade-up-delay-1 {
            animation: fadeUp 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }
        .animate-fade-up-delay-2 {
            animation: fadeUp 0.8s ease-out 0.4s forwards;
            opacity: 0;
        }
        .animate-fade-up-delay-3 {
            animation: fadeUp 0.8s ease-out 0.6s forwards;
            opacity: 0;
        }
        .animate-slide-right {
            animation: slideInRight 1s ease-out 0.3s forwards;
            opacity: 0;
        }
        .animate-breathe {
            animation: breathe 4s ease-in-out infinite;
        }
        .animate-pulse-glow {
            animation: pulseGlow 2.5s ease-out infinite;
        }
        .animate-cross {
            animation: crossMove 6s ease-in-out infinite;
        }

        /* Navigation */
        .nav-container {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 18px 0;
            background: rgba(250, 253, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(62, 130, 181, 0.12);
            transition: all 0.3s ease;
        }

        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--med-dark);
        }

        .logo-cross {
            position: relative;
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            font-weight: 700;
            box-shadow: 0 8px 24px rgba(62, 130, 181, 0.25);
            animation: crossMove 6s ease-in-out infinite;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .logo-text span {
            color: var(--med-teal);
            font-weight: 500;
        }

        .nav-buttons {
            display: flex;
            gap: 14px;
            align-items: center;
        }

        .btn {
            padding: 12px 26px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.2px;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.25, 0.8, 0.25, 1.2);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(62, 130, 181, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(62, 130, 181, 0.45);
        }

        .btn-outline {
            background: transparent;
            color: var(--med-blue);
            border: 2px solid rgba(62, 130, 181, 0.3);
        }

        .btn-outline:hover {
            border-color: var(--med-blue);
            background: rgba(62, 130, 181, 0.05);
            transform: translateY(-2px);
        }

        .btn-lg {
            padding: 16px 34px;
            font-size: 16px;
            border-radius: 60px;
        }

        /* Hero */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding: 120px 32px 80px;
            overflow: hidden;
        }

        .hero-bg-circle {
            position: absolute;
            border-radius: 50%;
            background: var(--med-mint);
            z-index: 0;
        }

        .hero-bg-circle-1 {
            width: 700px;
            height: 700px;
            top: -300px;
            right: -200px;
            animation: breathe 5s ease-in-out infinite;
        }

        .hero-bg-circle-2 {
            width: 450px;
            height: 450px;
            bottom: -150px;
            left: -120px;
            background: var(--med-sand);
            animation: breathe 5s ease-in-out 1.5s infinite;
        }

        .hero-bg-circle-3 {
            width: 200px;
            height: 200px;
            top: 30%;
            left: 55%;
            background: rgba(94, 168, 167, 0.12);
            animation: breathe 4s ease-in-out 2.5s infinite;
        }

        .hero-dots {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 1;
            opacity: 0.4;
            background-image: radial-gradient(circle, rgba(62, 130, 181, 0.3) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            padding: 10px 22px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            color: var(--med-teal);
            box-shadow: 0 4px 16px rgba(62, 130, 181, 0.08);
            margin-bottom: 28px;
            border: 1px solid rgba(94, 168, 167, 0.2);
        }

        .hero-badge-dot {
            width: 9px;
            height: 9px;
            background: var(--med-teal);
            border-radius: 50%;
            animation: pulseGlow 2s ease-out infinite;
        }

        .hero h1 {
            font-size: 54px;
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 24px;
            color: var(--med-dark);
        }

        .hero h1 .highlight {
            background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 18px;
            color: #5A7A8A;
            margin-bottom: 40px;
            max-width: 460px;
        }

        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .hero-card {
            background: white;
            border-radius: 28px;
            padding: 50px 40px;
            box-shadow: 0 30px 70px rgba(26, 60, 74, 0.1);
            text-align: center;
            position: relative;
            z-index: 3;
            border: 1px solid rgba(94, 168, 167, 0.15);
            width: 100%;
            max-width: 420px;
        }

        .hero-card-icon {
            font-size: 64px;
            margin-bottom: 16px;
            display: block;
            animation: crossMove 6s ease-in-out infinite;
        }

        .hero-card h3 {
            font-size: 22px;
            font-weight: 700;
            color: var(--med-dark);
            margin-bottom: 8px;
        }

        .hero-card .subtitle {
            font-size: 14px;
            color: #7A9AAA;
            font-weight: 500;
        }

        .hero-card-features {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 30px;
            text-align: left;
        }

        .hero-card-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #4A6A7A;
            padding: 10px 16px;
            background: var(--med-mint);
            border-radius: 12px;
        }

        .hero-card-feature .check {
            width: 28px;
            height: 28px;
            background: var(--med-teal);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            flex-shrink: 0;
        }

        /* Features */
        .section {
            padding: 100px 32px;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 40px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--med-dark);
            margin-bottom: 12px;
        }

        .section-header p {
            font-size: 17px;
            color: #6A8A9A;
            max-width: 500px;
            margin: 0 auto;
        }

        .features-grid {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 36px 28px;
            border: 1px solid rgba(94, 168, 167, 0.1);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1.2);
            cursor: default;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--med-blue) 0%, var(--med-teal) 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 50px rgba(26, 60, 74, 0.1);
            border-color: rgba(94, 168, 167, 0.3);
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 20px;
        }

        .fi-blue {
            background: #E0F0F8;
            color: var(--med-blue);
        }
        .fi-teal {
            background: #E0F5F4;
            color: var(--med-teal);
        }
        .fi-sand {
            background: var(--med-sand);
            color: #C4956A;
        }

        .feature-card h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--med-dark);
        }

        .feature-card p {
            font-size: 14px;
            color: #6A8A9A;
            line-height: 1.7;
        }

        /* Stats */
        .stats-strip {
            background: linear-gradient(135deg, var(--med-dark) 0%, #0E2A35 100%);
            padding: 50px 32px;
            margin: 40px auto;
            max-width: 1100px;
            border-radius: 28px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            box-shadow: 0 30px 60px rgba(26, 60, 74, 0.25);
            position: relative;
            overflow: hidden;
        }

        .stats-strip::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(126, 200, 227, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .stat-item {
            text-align: center;
            color: white;
            position: relative;
            z-index: 1;
        }

        .stat-number {
            font-size: 46px;
            font-weight: 700;
            letter-spacing: -1px;
            background: linear-gradient(135deg, var(--med-glow) 0%, var(--med-teal) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            margin-top: 4px;
        }

        /* CTA */
        .cta-section {
            text-align: center;
            padding: 40px 32px;
        }

        .cta-section .btn-lg {
            animation: pulseGlow 2.5s ease-out infinite;
        }

        /* Footer */
        .footer {
            background: var(--med-dark);
            color: rgba(255, 255, 255, 0.8);
            padding: 50px 32px 30px;
            font-size: 14px;
        }

        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
        }

        .footer h4 {
            color: white;
            font-weight: 600;
            margin-bottom: 14px;
            font-size: 15px;
        }

        .footer p,
        .footer li {
            line-height: 2;
        }

        .footer ul {
            list-style: none;
        }

        .footer-bottom {
            max-width: 1100px;
            margin: 30px auto 0;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .hero-inner {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 32px;
            }
            .hero p {
                margin: 0 auto 30px;
            }
            .hero h1 {
                font-size: 38px;
            }
            .hero-visual {
                order: -1;
            }
            .features-grid {
                grid-template-columns: 1fr;
                max-width: 450px;
            }
            .stats-strip {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .footer-inner {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        @media (max-width: 600px) {
            .nav-container {
                padding: 12px 0;
            }

            .nav-inner {
                padding: 0 16px;
                gap: 12px;
            }

            .logo {
                gap: 8px;
                min-width: 0;
            }

            .logo-cross {
                width: 36px;
                height: 36px;
                border-radius: 12px;
                flex-shrink: 0;
            }

            .logo-text {
                font-size: 16px;
                white-space: nowrap;
            }

            .nav-buttons {
                gap: 8px;
                flex-shrink: 0;
            }

            .nav-buttons .btn {
                padding: 9px 14px;
                font-size: 13px;
            }

            .nav-buttons .btn-outline {
                display: none;
            }

            .hero {
                min-height: auto;
                padding: 96px 18px 56px;
            }

            .hero h1 {
                font-size: 32px;
                letter-spacing: 0;
            }

            .hero p {
                font-size: 15px;
                margin-bottom: 26px;
            }

            .hero-card {
                padding: 32px 22px;
                border-radius: 22px;
            }

            .hero-bg-circle-1 {
                width: 360px;
                height: 360px;
                top: -170px;
                right: -170px;
            }

            .hero-bg-circle-2 {
                width: 280px;
                height: 280px;
                bottom: -120px;
                left: -150px;
            }

            .section {
                padding: 64px 18px;
            }
        }

        @media (max-width: 360px) {
            .logo-text {
                font-size: 14px;
            }

            .nav-buttons .btn {
                padding: 8px 11px;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="nav-container">
        <div class="nav-inner">
            <a href="/" class="logo">
                <div class="logo-cross">+</div>
                <div class="logo-text">Clinique <span>IIBS</span></div>
            </a>
            <div class="nav-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                        Dashboard →
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">
                        Connexion
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Inscription
                    </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-bg-circle hero-bg-circle-1"></div>
        <div class="hero-bg-circle hero-bg-circle-2"></div>
        <div class="hero-bg-circle hero-bg-circle-3"></div>
        <div class="hero-dots"></div>

        <div class="hero-inner">
            <div>
                <div class="hero-badge animate-fade-up">
                    <span class="hero-badge-dot"></span> Ouvert 24h/24 — 7j/7
                </div>
                <h1 class="animate-fade-up-delay-1">
                    Des soins <span class="highlight">d'exception</span><br>pour chaque patient
                </h1>
                <p class="animate-fade-up-delay-2">
                    Prenez rendez-vous avec nos médecins généralistes et spécialistes. Consultations, analyses, radiologie : tout est centralisé pour votre confort.
                </p>
                <div class="animate-fade-up-delay-3">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        Prendre un rendez-vous →
                    </a>
                </div>
            </div>
            <div class="hero-visual animate-slide-right">
                <div class="hero-card">
                    <span class="hero-card-icon">🏥</span>
                    <h3>Votre espace santé</h3>
                    <p class="subtitle">Simple • Rapide • Sécurisé</p>
                    <div class="hero-card-features">
                        <div class="hero-card-feature">
                            <span class="check">✓</span> Consultations médicales
                        </div>
                        <div class="hero-card-feature">
                            <span class="check">✓</span> Analyses & radiologie
                        </div>
                        <div class="hero-card-feature">
                            <span class="check">✓</span> Ordonnances en ligne
                        </div>
                        <div class="hero-card-feature">
                            <span class="check">✓</span> Suivi personnalisé
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 32px;">
        <div class="stats-strip">
            <div class="stat-item">
                <div class="stat-number">50+</div>
                <div class="stat-label">Médecins disponibles</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">15 000+</div>
                <div class="stat-label">Patients suivis</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">98%</div>
                <div class="stat-label">Satisfaction patient</div>
            </div>
        </div>
    </div>

    <!-- Services -->
    <section class="section">
        <div class="section-header">
            <h2>Nos services médicaux</h2>
            <p>Une prise en charge complète dans un environnement apaisant</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon fi-blue">🩺</div>
                <h3>Consultation générale</h3>
                <p>Médecins généralistes à votre écoute pour tous vos besoins de santé quotidiens.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon fi-teal">🦷</div>
                <h3>Spécialistes</h3>
                <p>Dentiste, ophtalmologue, cardiologue : une équipe d'experts à votre service.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon fi-sand">🔬</div>
                <h3>Analyses & radio</h3>
                <p>Laboratoire et imagerie médicale pour des diagnostics précis et rapides.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <div class="cta-section">
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg animate-pulse-glow">
            Créer mon compte patient →
        </a>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div>
                <h4>Clinique IIBS</h4>
                <p>Votre partenaire santé depuis 2005. Des soins de qualité dans un cadre rassurant et professionnel.</p>
            </div>
            <div>
                <h4>Services</h4>
                <ul>
                    <li>Consultations</li>
                    <li>Analyses médicales</li>
                    <li>Radiologie</li>
                    <li>Dentisterie</li>
                </ul>
            </div>
            <div>
                <h4>Contact</h4>
                <ul>
                    <li>📍 123 Av. de la Santé</li>
                    <li>📞 +33 1 23 45 67 89</li>
                    <li>✉️ contact@iibs-clinique.fr</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            © {{ date('Y') }} Clinique IIBS. Tous droits réservés.
        </div>
    </footer>

</body>
</html>
