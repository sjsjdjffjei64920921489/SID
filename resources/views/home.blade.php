<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explore SID Sports Center's 2026–27 football jersey collection.">
    <title>SID Sports Center — 2026–27 Jersey Collection</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="top">
    <a class="skip-link" href="#collection">Skip to the jersey collection</a>

    <header class="site-header">
        <a class="brand" href="{{ route('home') }}" aria-label="SID Sports Center home">
            <span class="brand-mark">SID<span>.</span></span>
            <span class="brand-name">SPORTS<br>CENTER</span>
        </a>
        <nav class="main-nav" aria-label="Main navigation">
            <a href="#collection">Jerseys <span>11</span></a>
            <a href="#about">About SID</a>
            @auth
                <span class="nav-greeting">Hi, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="nav-logout-form">
                    @csrf
                    <button class="nav-auth-link" type="submit">Log out</button>
                </form>
            @else
                <a class="nav-auth-link" href="{{ route('login') }}">Log in</a>
                <a class="nav-register" href="{{ route('register') }}">Register <span aria-hidden="true">↗</span></a>
            @endauth
            <a class="nav-contact" href="#contact">Get in touch <span aria-hidden="true">↗</span></a>
        </nav>
    </header>

    <main>
        @if (session('status'))
            <p class="site-status" role="status">{{ session('status') }}</p>
        @endif
        <section class="hero" aria-labelledby="hero-title">
            <div class="hero-copy">
                <p class="eyebrow"><span class="status-dot"></span> THE NEW SEASON IS HERE</p>
                <h1 id="hero-title">Wear the<br><em>whole game.</em></h1>
                <p class="hero-intro">Fresh colors. Legendary crests. Your next match-day favorite is waiting at SID Sports Center.</p>
                <a class="button button-lime" href="#collection">Explore the collection <span aria-hidden="true">↓</span></a>
                <div class="hero-stats" aria-label="Collection details">
                    <div><strong>11</strong><span>JERSEYS</span></div>
                    <div><strong>10</strong><span>TEAMS</span></div>
                    <div><strong>26-27</strong><span>SEASON</span></div>
                </div>
            </div>

            <a class="hero-feature" href="#collection" aria-label="Explore the Spain 2026–27 jersey">
                <div class="hero-photo">
                    <img src="{{ asset('images/jerseys/spain.jpg') }}" alt="Spain football jersey">
                    <span class="shirt-print hero-shirt-print" aria-hidden="true">26-27</span>
                    <span class="photo-season">2026–27<br><small>SEASON EDITION</small></span>
                    <span class="photo-index">01 / 11</span>
                </div>
                <div class="hero-photo-caption"><span>SPAIN · HOME JERSEY</span><span>VIEW COLLECTION ↘</span></div>
            </a>
            <span class="hero-orbit" aria-hidden="true">SID<br>26—27</span>
        </section>

        <section class="collection section-wrap" id="collection" aria-labelledby="collection-title">
            <div class="section-heading">
                <div>
                    <p class="eyebrow eyebrow-dark"><span class="status-dot"></span> THE 2026—27 LINEUP</p>
                    <h2 id="collection-title">Pick your <em>colors.</em></h2>
                </div>
                <p class="collection-note">Eleven jerseys.<br>Ten teams. One love of the game.</p>
            </div>

            <div class="product-grid">
                @foreach ($jerseys as $index => $jersey)
                    <article class="product-card" data-jersey-card>
                        <div class="product-photo">
                            <img
                                src="{{ asset('images/jerseys/' . $jersey['image']) }}"
                                alt="{{ $jersey['team'] }} 2026–27 football jersey"
                                loading="{{ $index < 4 ? 'eager' : 'lazy' }}"
                            >
                            <span
                                class="shirt-print"
                                style="--print-left: {{ $jersey['print_left'] }}%; --print-top: {{ $jersey['print_top'] }}%;"
                                aria-hidden="true"
                            >26-27</span>
                            <span class="product-number">{{ sprintf('%02d', $index + 1) }}</span>
                            <span class="season-badge">2026–27 <span>SEASON</span></span>
                        </div>
                        <div class="product-details">
                            <div>
                                <p class="team-name">{{ $jersey['team'] }}</p>
                                <h3>{{ $jersey['name'] }}</h3>
                            </div>
                            <span class="card-arrow" aria-hidden="true">↗</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="about-band" id="about">
            <div class="about-inner section-wrap">
                <p class="eyebrow"><span class="status-dot"></span> MORE THAN A KIT</p>
                <h2>For the first whistle.<br><em>And every one after.</em></h2>
                <p>SID Sports Center brings fans closer to the teams they love. Discover your next jersey in our 2026–27 collection.</p>
                <a class="text-link" href="#collection">Find your team <span aria-hidden="true">↗</span></a>
                <span class="about-watermark" aria-hidden="true">SID</span>
            </div>
        </section>

        <section class="contact-strip section-wrap" id="contact">
            <div>
                <p class="eyebrow eyebrow-dark">YOUR NEXT MATCH-DAY LOOK</p>
                <h2>Found your team?</h2>
            </div>
            <p>Contact SID Sports Center to ask about jersey availability and details.</p>
        </section>
    </main>

    <footer class="site-footer">
        <a class="brand footer-brand" href="{{ route('home') }}" aria-label="SID Sports Center home">
            <span class="brand-mark">SID<span>.</span></span>
            <span class="brand-name">SPORTS<br>CENTER</span>
        </a>
        <p>SID SPORTS CENTER <span>·</span> FOOTBALL SEASON 2026–27</p>
        <a href="#top">BACK TO TOP ↑</a>
    </footer>
</body>
</html>
