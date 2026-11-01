<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin | Luxora Yachts')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-shell">
    <header class="admin-topbar">
        <a class="admin-wordmark" href="{{ route('admin.dashboard') }}">LUXORA <span>ADMIN</span></a>
        <nav class="admin-nav" aria-label="Admin navigation">
            <a href="{{ route('admin.dashboard') }}">Overview</a>
            <a href="{{ route('admin.yachts.index') }}">Yachts</a>
            <a href="{{ route('admin.enquiries.index') }}">Enquiries</a>
            <a href="{{ route('admin.content.index') }}">Page content</a>
            <a href="{{ route('admin.newsletter.index') }}">Newsletter</a>
        </nav>
        <div class="admin-account">
            <span>{{ auth()->user()->email }}</span>
            <a href="{{ route('home') }}">View site</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Sign out</button>
            </form>
        </div>
    </header>

    <main class="admin-main">
        @if (session('status'))
            <p class="admin-alert admin-alert--success" role="status">{{ session('status') }}</p>
        @endif
        @if ($errors->any())
            <div class="admin-alert admin-alert--error" role="alert">
                <p>Please review the following fields:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
