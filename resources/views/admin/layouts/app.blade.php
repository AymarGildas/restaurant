<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: {{ $settings->primary_color ?? '#3498db' }};
            --secondary-color: {{  $settings->secondary_color  ?? '#2ecc71' }};
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            background-color: var(--primary-color);
            min-height: 100vh;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 0.75rem 1.25rem;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .topbar {
            background-color: white;
            border-bottom: 1px solid #ddd;
            padding: 1rem;
        }

        .footer {
            background: #f1f1f1;
            text-align: center;
            padding: 1rem;
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <h4 class="text-center py-3">Admin</h4>
             @can('access-dashboard')
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            @endcan
             
            @can('user-list')
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a>
            @endcan

            @can('client-list')
                <a href="{{ route('admin.clients.index') }}" class="{{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">Clients</a>
            @endcan

            @can('role-list')
                <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Roles</a>
            @endcan

            @can('menu-list')
                <a href="{{ route('admin.menus.index') }}" class="{{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">Menus</a>
            @endcan

            @can('type-list')
                <a href="{{ route('admin.types.index') }}" class="{{ request()->routeIs('admin.types.*') ? 'active' : '' }}">Types</a>
            @endcan

            @can('plat-list')
                <a href="{{ route('admin.plats.index') }}" class="{{ request()->routeIs('admin.plats.*') ? 'active' : '' }}">Plats</a>
            @endcan

            @can('order-list')
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Orders</a>
            @endcan

            @can('site-settings-access')
                <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">Settings</a>
            @endcan

            <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>


        <!-- Main content -->
        <div class="col-md-10">
            <div class="topbar">
                <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
            </div>

            <div class="p-4">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>

            <div class="footer">
                <small>&copy; {{ date('Y') }} Powered by C-G</small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
