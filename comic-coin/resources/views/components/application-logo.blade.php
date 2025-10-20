<svg
    {{ $attributes->merge(['class' => 'block h-9 w-9']) }}
    viewBox="0 0 64 64"
    role="img"
    aria-label="Comic Coin Logo"
    xmlns="http://www.w3.org/2000/svg"
>
    <title>Comic Coin</title>
    <defs>
        <linearGradient id="coin-fill" x1="0" x2="0" y1="0" y2="1">
            <stop offset="0%" stop-color="#FDE68A"/>
            <stop offset="60%" stop-color="#F59E0B"/>
            <stop offset="100%" stop-color="#D97706"/>
        </linearGradient>
        <linearGradient id="inner-fill" x1="0" x2="0" y1="0" y2="1">
            <stop offset="0%" stop-color="#FEF3C7"/>
            <stop offset="100%" stop-color="#FBBF24"/>
        </linearGradient>
    </defs>

    <!-- Outer coin -->
    <circle cx="32" cy="32" r="30" fill="url(#coin-fill)" stroke="#B45309" stroke-width="2"/>

    <!-- Rim detail -->
    <circle cx="32" cy="32" r="24" fill="url(#inner-fill)" stroke="#92400E" stroke-width="2"/>

    <!-- Simple mark: stylized C -->
    <path d="M42 32c0 6.627-5.373 12-12 12s-12-5.373-12-12 5.373-12 12-12c3.2 0 6.1 1.292 8.22 3.38l-3.02 3.02A8 8 0 0 0 30 22c-4.418 0-8 3.582-8 10s3.582 10 8 10a8 8 0 0 0 5.2-1.9l3.1 3.1A12 12 0 0 1 30 44c-6.627 0-12-5.373-12-12s5.373-12 12-12 12 5.373 12 12z" fill="#92400E" fill-opacity="0.9"/>

    <!-- Highlight -->
    <path d="M14 28c2-8 9.5-14 18-14 3.5 0 6.7 1 9.5 2.7" fill="none" stroke="#FFFFFF" stroke-opacity="0.5" stroke-width="3" stroke-linecap="round"/>
</svg>
