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
            background: linear-gradient(135deg, #1a1f35 0%, #0f1220 100%);
            color: #e0e0e0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
            background: #0f1220;
            padding: 3rem 2.5rem;
            border-radius: 12px;
            border: 1px solid #2a3150;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.75rem;
            font-weight: bold;
            color: #4a9eff;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: none;
        }

        .logo-img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        h1 {
            color: #ffffff;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .subtitle {
            color: #9095a0;
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #c0c0c0;
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 0.875rem 1rem;
            background: #1a1f35;
            border: 1px solid #2a3150;
            border-radius: 6px;
            color: #e0e0e0;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #4a9eff;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
        }

        .checkbox-group label {
            margin-bottom: 0;
        }

        .btn {
            width: 100%;
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: #3b82f6;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .success {
            background: #10b981;
            color: #ffffff;
            padding: 0.875rem 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .links {
            margin-top: 1.5rem;
            text-align: center;
        }

        .links a {
            color: #4a9eff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .links a:hover {
            color: #3b82f6;
            text-decoration: underline;
        }

        .divider {
            margin: 1.5rem 0;
            text-align: center;
            color: #9095a0;
        }

        @yield('styles')
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="logo-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('RL-Logo.png') }}" alt="Rocket League Logo" class="logo-img">
                RL Tracker
            </a>
        </div>

        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
