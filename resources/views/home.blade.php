<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rocket League Community - Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1a1f35;
            color: #e0e0e0;
            min-height: 100vh;
        }

        /* Header */
        header {
            background: #0f1220;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #2a3150;
        }

        nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 2rem;
            font-weight: bold;
            color: #4a9eff;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .logo-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: #c0c0c0;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 0.5rem 1rem;
        }

        .nav-links a:hover {
            color: #4a9eff;
        }

        /* Hero Section */
        .hero {
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            color: #ffffff;
        }

        .hero p {
            font-size: 1.3rem;
            color: #a0aec0;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #3b82f6;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-secondary {
            background: transparent;
            color: #3b82f6;
            border: 2px solid #3b82f6;
        }

        .btn-secondary:hover {
            background: #3b82f6;
            color: #ffffff;
        }

        /* Features Section */
        .features {
            max-width: 1200px;
            margin: 6rem auto;
            padding: 0 2rem;
        }

        .features h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #ffffff;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: #0f1220;
            padding: 2rem;
            border-radius: 8px;
            border: 1px solid #2a3150;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
            cursor: pointer;
        }

        .feature-card:hover {
            border-color: #3b82f6;
            background: #151b2e;
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #ffffff;
        }

        .feature-card p {
            color: #9095a0;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            background: #0f1220;
            padding: 4rem 2rem;
            margin: 4rem 0;
            border-top: 1px solid #2a3150;
            border-bottom: 1px solid #2a3150;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3rem;
            color: #3b82f6;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            color: #9095a0;
            font-size: 1.1rem;
        }

        /* Footer */
        footer {
            background: #0f1220;
            padding: 2rem;
            text-align: center;
            margin-top: 4rem;
            border-top: 1px solid #2a3150;
        }

        footer p {
            color: #9095a0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .nav-links {
                gap: 1rem;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header/Navigation -->
    <header>
        <nav>
            <div class="logo">
                <img src="{{ asset('RL-Logo.png') }}" alt="Rocket League Logo" class="logo-img">
                Rocket League Tracker
            </div>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/nieuws">Nieuws</a></li>
                <li><a href="/spelers">Spelers</a></li>
                <li><a href="/faq">FAQ</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/login">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Welkom bij Rocket League Tracker</h1>
        <p>
            Het platform voor alles over Rocket League!<br>
            Volg de laatste nieuwtjes, bekijk speler profielen, toernooien en meer.
        </p>
        <div class="cta-buttons">
            <a href="/register" class="btn btn-primary">Word Lid</a>
            <a href="/nieuws" class="btn btn-secondary">Laatste Nieuws</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2>Wat We Bieden</h2>
        <div class="features-grid">
            <a href="/nieuws" class="feature-card">
                <div class="feature-icon">📰</div>
                <h3>Laatste Nieuws</h3>
                <p>
                    Blijf op de hoogte van de nieuwste patches, updates, esports evenementen en community highlights.
                </p>
            </a>

            <a href="/spelers" class="feature-card">
                <div class="feature-icon">👤</div>
                <h3>Speler Profielen</h3>
                <p>
                    Creëer je eigen profiel, deel je stats en laat zien welke rank je hebt bereikt.
                </p>
            </a>

            <a href="/toernooien" class="feature-card">
                <div class="feature-icon">🏆</div>
                <h3>Toernooien</h3>
                <p>
                    Bekijk aankomende toernooien, schrijf je in en volg de resultaten van professionele competities.
                </p>
            </a>

            <a href="/ranked" class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Ranked Systeem</h3>
                <p>
                    Volg je rank progression van Bronze tot Grand Champion en SSL. Bekijk jouw MMR geschiedenis en climb de ladder!
                </p>
            </a>

            <a href="/faq" class="feature-card">
                <div class="feature-icon">❓</div>
                <h3>FAQ & Guides</h3>
                <p>
                    Leer nieuwe mechanics, ontdek tips & tricks en krijg antwoorden op al je Rocket League vragen.
                </p>
            </a>

            <a href="/community" class="feature-card">
                <div class="feature-icon">💬</div>
                <h3>Community</h3>
                <p>
                    Maak contact met andere spelers, vorm teams en deel je Rocket League ervaringen.
                </p>
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-container">
            <div class="stat-item">
                <h3>250+</h3>
                <p>Actieve Spelers</p>
            </div>
            <div class="stat-item">
                <h3>50+</h3>
                <p>Nieuws Items</p>
            </div>
            <div class="stat-item">
                <h3>15</h3>
                <p>Toernooien</p>
            </div>
            <div class="stat-item">
                <h3>100+</h3>
                <p>Car Builds</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Rocket League Community. Gemaakt met Laravel 12.</p>
        <p>Dit is een fan-made website en is niet officieel geaffilieerd met Psyonix of Epic Games.</p>
    </footer>
</body>
</html>
