<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">
            {{ __('Top Up Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Current Balance -->
            <div class="bg-base-100 shadow-lg rounded-lg p-6 mb-8 text-center">
                <h3 class="text-lg font-medium text-base-content/70">{{ __('Your Current Balance') }}</h3>
                <p class="text-5xl font-bold text-primary mt-2">{{ Auth::user()->coins ?? 0 }} <span class="text-3xl">{{ __('Coins') }}</span></p>
            </div>

            @if(session('success'))
                <div class="alert alert-success shadow-lg mb-6">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Top-up Packages -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($topupPackages as $package)
                    <div class="card bg-base-200 shadow-xl border-2 border-transparent hover:border-primary transition-all duration-300">
                        <div class="card-body items-center text-center">
                            <h2 class="card-title text-4xl font-bold text-primary">{{ $package['coins'] }}</h2>
                            <p class="text-base-content/80">{{ __('Coins') }}</p>
                            @if ($package['bonus'] > 0)
                                <div class="badge badge-secondary">+{{ $package['bonus'] }} Bonus!</div>
                            @endif
                            <div class="my-4">
                                <span class="text-2xl font-semibold">฿{{ $package['price'] }}</span>
                            </div>
                            <div class="card-actions">
                                <form action="{{ route('wallet.processTopup') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="coins" value="{{ $package['coins'] + $package['bonus'] }}">
                                    <button type="submit" class="btn btn-primary btn-wide">{{ __('Top Up Now') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
