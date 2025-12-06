<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Rocket League Community</title>
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
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #0f1220;
            border-right: 1px solid #2a3150;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 0 1.5rem;
            margin-bottom: 2rem;
        }

        .sidebar-header h2 {
            color: #4a9eff;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-header .admin-badge {
            background: #f59e0b;
            color: #000;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: bold;
            display: inline-block;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.5rem;
            color: #c0c0c0;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background: #151b2e;
            color: #4a9eff;
            border-left-color: #4a9eff;
        }

        .sidebar-menu li a .icon {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-divider {
            height: 1px;
            background: #2a3150;
            margin: 1rem 0;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: #0f1220;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #2a3150;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #4a9eff;
            font-size: 1.75rem;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #9095a0;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #2a3150;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #4a9eff;
        }

        /* Content Area */
        .content {
            flex: 1;
            padding: 2rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: #10b981;
            color: #fff;
            border: 1px solid #059669;
        }

        .alert-error {
            background: #ef4444;
            color: #fff;
            border: 1px solid #dc2626;
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
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
            background: #6b7280;
            color: #ffffff;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-success {
            background: #10b981;
            color: #ffffff;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-warning {
            background: #f59e0b;
            color: #000;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: #ef4444;
            color: #ffffff;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        /* Cards */
        .card {
            background: #0f1220;
            padding: 2rem;
            border-radius: 8px;
            border: 1px solid #2a3150;
            margin-bottom: 1.5rem;
        }

        .card-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #2a3150;
        }

        .card-header h3 {
            color: #4a9eff;
            font-size: 1.25rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #c0c0c0;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            background: #1a1f35;
            border: 1px solid #2a3150;
            border-radius: 5px;
            color: #e0e0e0;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: #4a9eff;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #151b2e;
        }

        table th,
        table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #2a3150;
        }

        table th {
            color: #4a9eff;
            font-weight: 600;
        }

        table tr:hover {
            background: #151b2e;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: bold;
            display: inline-block;
        }

        .badge-admin {
            background: #f59e0b;
            color: #000;
        }

        .badge-user {
            background: #6b7280;
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }

            .content {
                padding: 1rem;
            }
        }

        @yield('styles')
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
            <span class="admin-badge">ADMIN</span>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="icon">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <span class="icon">Gebruikers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.nieuws') }}" class="{{ request()->routeIs('admin.nieuws*') ? 'active' : '' }}">
                    <span class="icon">Nieuws</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.faq.items') }}" class="{{ request()->routeIs('admin.faq*') ? 'active' : '' }}">
                    <span class="icon">FAQ</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.contact.messages') }}" class="{{ request()->routeIs('admin.contact*') ? 'active' : '' }}">
                    <span class="icon">Contact</span>
                    @php
                        $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span style="background: #ef4444; color: #fff; padding: 0.15rem 0.5rem; border-radius: 10px; font-size: 0.75rem; margin-left: 0.5rem; font-weight: bold;">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tournaments.index') }}" class="{{ request()->routeIs('admin.tournaments*') ? 'active' : '' }}">
                    <span class="icon">Toernooien</span>
                </a>
            </li>

            <div class="sidebar-divider"></div>

            <li>
                <a href="{{ route('home') }}">
                    <span class="icon">Home</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <h1>@yield('page-title', 'Admin Dashboard')</h1>

            <div class="header-actions">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">
                        Uitloggen
                    </button>
                </form>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <span>✗</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <div>
                        <strong>Er zijn fouten opgetreden:</strong>
                        <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>
</html>
