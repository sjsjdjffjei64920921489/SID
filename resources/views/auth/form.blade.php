<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $mode === 'register' ? 'Create a SID Sports Center account.' : 'Log in to your SID Sports Center account.' }}">
    <title>{{ $mode === 'register' ? 'Create account' : 'Log in' }} — SID Sports Center</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-body">
    <a class="skip-link" href="#auth-form">Skip to the form</a>
    <header class="site-header auth-header">
        <a class="brand" href="{{ route('home') }}" aria-label="SID Sports Center home">
            <span class="brand-mark">SID<span>.</span></span>
            <span class="brand-name">SPORTS<br>CENTER</span>
        </a>
        <a class="auth-back-link" href="{{ route('home') }}">← Back to collection</a>
    </header>

    <main class="auth-page">
        <section class="auth-panel" aria-labelledby="auth-title">
            <p class="eyebrow eyebrow-dark"><span class="status-dot"></span> SID SPORTS CENTER</p>
            <h1 id="auth-title">{{ $mode === 'register' ? 'Join the club.' : 'Good to see you.' }}</h1>
            <p class="auth-intro">
                {{ $mode === 'register' ? 'Create your account and stay close to the teams you love.' : 'Log in to your SID Sports Center account.' }}
            </p>

            @if (session('status'))
                <p class="form-status" role="status">{{ session('status') }}</p>
            @endif

            <form id="auth-form" class="auth-form" action="{{ $mode === 'register' ? route('register.store') : route('login.store') }}" method="POST">
                @csrf

                @if ($mode === 'register')
                    <div class="form-field">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" maxlength="255" required autofocus aria-describedby="name-error">
                        @error('name')
                            <p class="field-error" id="name-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <div class="form-field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" required {{ $mode === 'login' ? 'autofocus' : '' }} aria-describedby="email-error">
                    @error('email')
                        <p class="field-error" id="email-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" autocomplete="{{ $mode === 'register' ? 'new-password' : 'current-password' }}" required @if ($mode === 'register') minlength="8" aria-describedby="password-error" @endif>
                    @error('password')
                        <p class="field-error" id="password-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                @if ($mode === 'register')
                    <div class="form-field">
                        <label for="password_confirmation">Confirm password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" required>
                    </div>
                @else
                    <label class="remember-option" for="remember">
                        <input id="remember" name="remember" type="checkbox" value="1">
                        <span>Remember me</span>
                    </label>
                @endif

                <button class="button button-lime auth-submit" type="submit">
                    {{ $mode === 'register' ? 'Create account' : 'Log in' }}
                    <span aria-hidden="true">↗</span>
                </button>
            </form>

            <p class="auth-switch">
                @if ($mode === 'register')
                    Already registered? <a href="{{ route('login') }}">Log in</a>
                @else
                    New to SID? <a href="{{ route('register') }}">Create an account</a>
                @endif
            </p>
        </section>
        <aside class="auth-aside" aria-label="SID Sports Center">
            <span class="auth-aside-season">2026—27<br><small>SEASON COLLECTION</small></span>
            <p>Wear the<br><em>whole game.</em></p>
            <span class="auth-aside-mark" aria-hidden="true">SID.</span>
        </aside>
    </main>

    <footer class="auth-footer">
        <a class="brand footer-brand" href="{{ route('home') }}" aria-label="SID Sports Center home">
            <span class="brand-mark">SID<span>.</span></span>
            <span class="brand-name">SPORTS<br>CENTER</span>
        </a>
        <p>SID SPORTS CENTER <span>·</span> FOOTBALL SEASON 2026–27</p>
    </footer>
</body>
</html>
