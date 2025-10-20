<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Comic Coin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="navbar bg-base-100 shadow-lg">
            <div class="flex-1">
                <a class="btn btn-ghost normal-case text-xl" href="/">Comic Coin</a>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1">
                    @if (Route::has('login'))
                        @auth
                            <li><a href="{{ route('comics.index') }}">Comics</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Log in</a></li>

                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>

        <div class="hero min-h-screen" style="background-image: url('{{ asset('hanma.jpg') }}');">
            <div class="hero-overlay bg-opacity-60"></div>
            <div class="hero-content text-center text-neutral-content">
                <div class="max-w-md">
                    <h1 class="mb-5 text-5xl font-bold">Welcome to Comic Coin</h1>
                    <p class="mb-5">Your one-stop platform to read exclusive digital comics. Dive into new worlds and support your favorite creators.</p>
                    <a href="{{ route('comics.index') }}" class="btn btn-primary">Explore Comics</a>
                </div>
            </div>
        </div>

        <footer class="footer footer-center p-4 bg-base-300 text-base-content">
            <div>
                <p>Copyright © 2025 - All right reserved by Comic Coin Industries Ltd</p>
            </div>
        </footer>
    </body>
</html>
