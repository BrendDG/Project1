@extends('layouts.app')

@section('title', 'Rocket League Community - Home')

@section('styles')
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
@endsection

@section('content')
    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    <!-- Hero Section -->
    <section class="hero">
        <h1>Welkom bij Rocket League Tracker</h1>
        <p>
            Het platform voor alles over Rocket League!<br>
            Volg de laatste nieuwtjes, bekijk speler profielen, toernooien en meer.
        </p>
        <div class="cta-buttons">
            @auth
                <a href="{{ route('profile.show', auth()->user()) }}" class="btn btn-primary">Mijn Profiel</a>
                <a href="{{ route('nieuws.index') }}" class="btn btn-secondary">Laatste Nieuws</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary">Word Lid</a>
                <a href="{{ route('nieuws.index') }}" class="btn btn-secondary">Laatste Nieuws</a>
            @endauth
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2>Wat We Bieden</h2>
        <div class="features-grid">
            <a href="{{ route('nieuws.index') }}" class="feature-card">
                <h3>Laatste Nieuws</h3>
                <p>
                    Blijf op de hoogte van de nieuwste patches, updates, esports evenementen en community highlights.
                </p>
            </a>

            @auth
                <a href="{{ route('profile.show', auth()->user()) }}" class="feature-card">
                    <h3>Mijn Profiel</h3>
                    <p>
                        Bekijk en bewerk je profiel, deel je stats en laat zien welke rank je hebt bereikt.
                    </p>
                </a>
            @else
                <a href="{{ route('register') }}" class="feature-card">
                    <h3>Speler Profielen</h3>
                    <p>
                        Creëer je eigen profiel, deel je stats en laat zien welke rank je hebt bereikt.
                    </p>
                </a>
            @endauth

            <a href="{{ route('tournaments.index') }}" class="feature-card">
                <h3>Toernooien</h3>
                <p>
                    Bekijk aankomende toernooien.
                </p>
            </a>

            <a href="{{ route('ranked.index') }}" class="feature-card">
                <h3>Ranked Systeem</h3>
                <p>
                    Bekijk de volledige MMR ranges voor alle ranks van Bronze tot Supersonic Legend. Ontdek bij welke MMR je promoveert of degradeert!
                </p>
            </a>

            <a href="{{ route('faq.index') }}" class="feature-card">
                <h3>FAQ</h3>
                <p>
                    Leer nieuwe mechanics, ontdek tips & tricks en krijg antwoorden op al je Rocket League vragen.
                </p>
            </a>

            <a href="{{ route('contact.index') }}" class="feature-card">
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
@endsection
