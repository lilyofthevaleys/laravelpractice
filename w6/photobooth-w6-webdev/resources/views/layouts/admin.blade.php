<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémart Admin - @yield('title')</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Ccircle cx='32' cy='32' r='30' fill='%23ffffff' stroke='%231a1a1a' stroke-width='4'/%3E%3Cpath d='M2 32 a30 30 0 0 1 60 0 z' fill='%23ee1515' stroke='%231a1a1a' stroke-width='4'/%3E%3Crect x='0' y='28' width='64' height='8' fill='%231a1a1a'/%3E%3Ccircle cx='32' cy='32' r='8' fill='%23ffffff' stroke='%231a1a1a' stroke-width='3'/%3E%3Ccircle cx='32' cy='32' r='3' fill='%23ffffff' stroke='%231a1a1a' stroke-width='2'/%3E%3C/svg%3E">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --poke-red: #ee1515;
            --poke-red-dark: #a51818;
            --poke-ink: #1a1a1a;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f5f7;
        }
        .brand-font { font-family: 'Press Start 2P', monospace; letter-spacing: -1px; }
        .pokeball {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(180deg, var(--poke-red) 49%, var(--poke-ink) 49%, var(--poke-ink) 55%, #fff 55%);
            border: 3px solid var(--poke-ink); position: relative;
        }
        .pokeball::after {
            content: ''; position: absolute; top: 50%; left: 50%;
            width: 10px; height: 10px; margin: -5px 0 0 -5px;
            background: #fff; border: 2px solid var(--poke-ink); border-radius: 50%;
        }
        .admin-shell { display: flex; min-height: 100vh; }
        .admin-sidebar {
            width: 260px; background: var(--poke-ink); color: #fff;
            padding: 1.5rem 1rem; flex-shrink: 0;
            position: sticky; top: 0; height: 100vh; overflow-y: auto;
        }
        .admin-sidebar .brand { color: #fff; text-decoration: none; display: flex; align-items: center; gap: 0.6rem; padding: 0.5rem; }
        .admin-sidebar .nav-link {
            color: rgba(255,255,255,0.75); font-weight: 600;
            padding: 0.7rem 0.9rem; border-radius: 8px; margin-bottom: 4px;
        }
        .admin-sidebar .nav-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .admin-sidebar .nav-link.active { background: var(--poke-red); color: #fff; }
        .admin-sidebar .sidebar-footer { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem; margin-top: 1rem; }
        .admin-main { flex-grow: 1; padding: 2rem; }
        .admin-topbar {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 1.5rem;
        }
        .stat-card { border: none; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .stat-card .stat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: #fff;
        }
        .admin-card { border: none; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); background: #fff; }
        .badge-status { padding: 0.35em 0.7em; border-radius: 999px; font-weight: 600; font-size: 0.75rem; }
        .badge-paid { background: #d1f7c4; color: #256029; }
        .badge-pending { background: #fff4d6; color: #7a5a00; }
        .badge-failed, .badge-cancelled { background: #ffdad4; color: #9c2a1b; }
        .badge-active { background: #d1f7c4; color: #256029; }
        .badge-expired { background: #e2e2e2; color: #444; }
        .badge-role-admin { background: #ee1515; color: #fff; }
        .badge-role-customer { background: #e2e8f0; color: #1a202c; }
        @media (max-width: 768px) {
            .admin-shell { flex-direction: column; }
            .admin-sidebar { width: 100%; position: static; height: auto; }
        }
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="brand mb-4">
                <span class="pokeball"></span>
                <span class="brand-font small">Pokémart</span>
            </a>
            @php $inboxUnreadCount = \App\Models\ContactMessage::unread()->count(); @endphp
            <nav class="nav flex-column">
                <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link d-flex justify-content-between align-items-center {{ Request::routeIs('admin.inbox.*') ? 'active' : '' }}" href="{{ route('admin.inbox.index') }}">
                    <span>Inbox</span>
                    @if ($inboxUnreadCount > 0)
                        <span class="badge rounded-pill" style="background:#ee1515;color:#fff;">{{ $inboxUnreadCount }}</span>
                    @endif
                </a>
                <a class="nav-link {{ Request::routeIs('admin.transactions.*') ? 'active' : '' }}" href="{{ route('admin.transactions.index') }}">Transactions</a>
                <a class="nav-link {{ Request::routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Users</a>
                <a class="nav-link {{ Request::routeIs('admin.subscriptions.*') ? 'active' : '' }}" href="{{ route('admin.subscriptions.index') }}">Subscriptions</a>
                <a class="nav-link {{ Request::routeIs('admin.shop.*') ? 'active' : '' }}" href="{{ route('admin.shop.index') }}">Manage Pokémon</a>
                <a class="nav-link {{ Request::routeIs('admin.items.*') ? 'active' : '' }}" href="{{ route('admin.items.index') }}">Manage Items</a>
            </nav>
            <div class="sidebar-footer">
                <div class="small text-white-50 mb-2">Signed in as</div>
                <div class="fw-bold">{{ Auth::user()->name }}</div>
                <div class="small text-white-50 mb-3">{{ Auth::user()->email }}</div>
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light w-100 mb-2">View Store</a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger w-100">Log out</button>
                </form>
            </div>
        </aside>

        <main class="admin-main">
            <div class="admin-topbar">
                <div>
                    <h2 class="fw-bold mb-0">@yield('heading')</h2>
                    <div class="text-muted small">@yield('subheading')</div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @yield('scripts')
</body>
</html>
