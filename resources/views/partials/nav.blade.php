<header class="nav" id="nav">
    <nav class="nav__left">
        <button class="nav__menu" id="menuBtn" aria-label="Open menu" aria-controls="drawer" aria-expanded="false">MENU</button>
        <span class="nav__divider" aria-hidden="true"></span>
        <a href="{{ route('charter') }}" class="{{ request()->routeIs('charter') ? 'is-active' : '' }}">CHARTER</a>
        <a href="{{ route('yachts.index') }}" class="{{ request()->routeIs('yachts.*') ? 'is-active' : '' }}">YACHTS</a>
        <a href="{{ route('buy') }}" class="{{ request()->routeIs('buy') ? 'is-active' : '' }}">BUY</a>
        <a href="{{ route('build') }}" class="{{ request()->routeIs('build') ? 'is-active' : '' }}">BUILD</a>
        <a href="{{ route('design') }}" class="{{ request()->routeIs('design') ? 'is-active' : '' }}">DESIGN</a>
    </nav>

    <a href="{{ route('home') }}" class="nav__logo">LUXORA YACHTS</a>

    <div class="nav__right">
        <a href="{{ route('contact') }}">CONTACT</a>
        <span class="nav__divider"></span>
        <a class="nav__search-link" href="{{ route('charter') }}#charter-finder" aria-label="Search charter yachts">
            <svg class="nav__search" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="10" cy="10" r="6.5"/><path d="M15 15l6 6"/></svg>
        </a>
        @guest
            <a href="{{ route('login') }}" class="nav__account">SIGN IN</a>
            <a href="{{ route('register') }}" class="nav__btn">JOIN US</a>
        @else
            <a href="{{ route('account') }}" class="nav__account">MY ACCOUNT</a>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="nav__account">ADMIN</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="nav__logout">
                @csrf
                <button type="submit" class="nav__btn">SIGN OUT</button>
            </form>
        @endguest
    </div>
</header>

<div class="drawer" id="drawer" role="dialog" aria-modal="false" aria-labelledby="drawerTitle" aria-hidden="true" inert tabindex="-1">
    <div class="drawer__top">
        <a class="drawer__wordmark" href="{{ route('home') }}">LUXORA <span>YACHTS</span></a>
        <button class="drawer__close" id="drawerClose" aria-label="Close menu"><span>CLOSE</span><i aria-hidden="true">&times;</i></button>
    </div>
    <div class="drawer__layout">
        <div class="drawer__main">
            <p class="drawer__eyebrow" id="drawerTitle">EXPLORE LUXORA</p>
            <nav class="drawer__links" aria-label="Main menu">
                <a class="{{ request()->routeIs('charter') ? 'is-active' : '' }}" href="{{ route('charter') }}"><span>01</span>Charter</a>
                <a class="{{ request()->routeIs('yachts.*') ? 'is-active' : '' }}" href="{{ route('yachts.index') }}"><span>02</span>Yacht profiles</a>
                <a class="{{ request()->routeIs('destinations') ? 'is-active' : '' }}" href="{{ route('destinations') }}"><span>03</span>Destinations</a>
                <a class="{{ request()->routeIs('buy') ? 'is-active' : '' }}" href="{{ route('buy') }}"><span>04</span>Buy a yacht</a>
                <a class="{{ request()->routeIs('build') ? 'is-active' : '' }}" href="{{ route('build') }}"><span>05</span>New build</a>
                <a class="{{ request()->routeIs('design') ? 'is-active' : '' }}" href="{{ route('design') }}"><span>06</span>Design &amp; refit</a>
            </nav>
        </div>
        <aside class="drawer__aside">
            <div class="drawer__feature">
                <p class="drawer__eyebrow">YOUR NEXT CHAPTER</p>
                <h2>A little more<br>room to roam.</h2>
                <p>From the first idea to the open water, our team helps bring every detail together.</p>
                <a class="drawer__cta" href="{{ route('contact') }}">START A CONVERSATION <span aria-hidden="true">&rarr;</span></a>
            </div>
            <div class="drawer__secondary">
                <p class="drawer__eyebrow">MORE FROM LUXORA</p>
                <a href="{{ route('sell') }}">Sell a yacht</a>
                <a href="{{ route('management') }}">Yacht management</a>
                <a href="{{ route('crew') }}">Crew services</a>
                <a href="{{ route('about') }}">About us</a>
                <a href="{{ route('news') }}">Journal</a>
                <a href="{{ route('careers') }}">Careers</a>
            </div>
        </aside>
    </div>
    <div class="drawer__footer">
        <span>EXPERIENCE THE EXTRAORDINARY</span>
        <div>
            @guest
                <a href="{{ route('login') }}">Sign in</a>
                <a href="{{ route('register') }}">Create an account <span aria-hidden="true">&rarr;</span></a>
            @else
                <a href="{{ route('account') }}">My account</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">Admin panel</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="drawer__logout">
                    @csrf
                    <button type="submit">Sign out</button>
                </form>
            @endguest
        </div>
    </div>
</div>
