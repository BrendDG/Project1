<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rocket League Community')</title>
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
            text-decoration: none;
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

        .nav-links a:hover,
        .nav-links a.active {
            color: #4a9eff;
        }

        /* Main Content */
        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
            min-height: calc(100vh - 400px);
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

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
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

        /* Cards */
        .card {
            background: #0f1220;
            padding: 2rem;
            border-radius: 8px;
            border: 1px solid #2a3150;
            transition: all 0.3s ease;
        }

        .card:hover {
            border-color: #3b82f6;
            background: #151b2e;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                gap: 1rem;
                font-size: 0.9rem;
            }

            main {
                padding: 0 1rem;
            }
        }

        @yield('styles')
    </style>
</head>
<body>
    <!-- Header/Navigation -->
    <header>
        <nav>
            <a href="/" class="logo">
                <img src="{{ asset('RL-Logo.png') }}" alt="Rocket League Logo" class="logo-img">
                Rocket League Tracker
            </a>
            <ul class="nav-links">
                <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('nieuws.index') }}" class="{{ request()->is('nieuws*') ? 'active' : '' }}">Nieuws</a></li>
                <li><a href="/spelers">Spelers</a></li>
                <li><a href="/faq">FAQ</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/login">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Rocket League Community. Gemaakt met Laravel 12.</p>
        <p>Dit is een fan-made website en is niet officieel geaffilieerd met Psyonix of Epic Games.</p>
    </footer>

    @yield('scripts')
</body>
</html>
