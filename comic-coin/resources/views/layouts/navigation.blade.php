<nav x-data="{ open: false }" class="bg-base-300 border-b border-base-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-base-content">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('comics.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('comics.index')" :active="request()->routeIs('comics.index')">
                        {{ __('Comics') }}
                    </x-nav-link>

                    @auth
                        @if(Auth::user()->is_admin)
                        <x-nav-link :href="route('wallet.index')" :active="request()->routeIs('wallet.index')">
                            {{ __('Wallet') }}
                        </x-nav-link>
                        <x-nav-link :href="route('banners.index')" :active="request()->routeIs('banners.index')">
                            {{ __('Manage Banners') }}
                        </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">

                <!-- Language Switcher -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-base-content hover:text-primary focus:outline-none transition ease-in-out duration-150">
                                <div>{{ strtoupper(app()->getLocale()) }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('language.switch', 'en')">
                                English (EN)
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('language.switch', 'th')">
                                ภาษาไทย (TH)
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-base-content hover:text-primary focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }} ({{ Auth::user()->coins ?? 0 }} Coins)</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('wallet.topup')">
                            {{ __('Top Up') }}
                        </x-dropdown-link>

                        @if(Auth::user()->is_admin)
                        <x-dropdown-link :href="route('wallet.index')">
                            {{ __('Top-up Coins') }}
                        </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
                @guest
                    <div class="ml-3">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-ghost">{{ __('Log in') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-sm btn-primary ml-2">{{ __('Register') }}</a>
                        @endif
                    </div>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-base-content/70 hover:text-base-content hover:bg-base-200 focus:outline-none focus:bg-base-200 focus:text-base-content transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('comics.index')" :active="request()->routeIs('comics.index')">
                {{ __('Comics') }}
            </x-responsive-nav-link>
            @auth
                @if(Auth::user()->is_admin)
                <x-responsive-nav-link :href="route('wallet.index')" :active="request()->routeIs('wallet.index')">
                    {{ __('Wallet') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('banners.index')" :active="request()->routeIs('banners.index')">
                    {{ __('Manage Banners') }}
                </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-base-300">
                <div class="px-4">
                    <div class="font-medium text-base text-base-content">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-base-content/80">{{ Auth::user()->email }} ({{ Auth::user()->coins ?? 0 }} Coins)</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('wallet.topup')">
                        {{ __('Top Up') }}
                    </x-responsive-nav-link>

                    @if(Auth::user()->is_admin)
                    <x-responsive-nav-link :href="route('wallet.index')">
                        {{ __('Top-up Coins') }}
                    </x-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
        @guest
            <div class="pt-4 pb-1 border-t border-base-300">
                <div class="px-4">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            </div>
        @endguest
    </div>
</nav>
