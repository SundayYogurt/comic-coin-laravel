<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-base-content">
                {{ __('Comics') }}
            </h2>
            @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isTranslator()))
            <a href="{{ route('comics.create') }}" class="btn btn-accent">{{ __('Add New Comic') }}</a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

            <!-- Hero Banner -->
            @if(isset($banners) && $banners->count() > 0)
                <div class="carousel w-full rounded-box shadow-xl overflow-x-hidden" style="height: 400px;">
                    @foreach($banners as $key => $banner)
                        <div id="slide{{ $key }}" class="carousel-item relative w-full">
                            <a href="{{ $banner->link ?? '#' }}" class="w-full">
                                <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full object-cover" />
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 p-6">
                                    <h3 class="text-white text-3xl font-bold">{{ $banner->title }}</h3>
                                    <p class="text-gray-200">{{ $banner->description }}</p>
                                </div>
                            </a>
                            <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                <a href="#slide{{ $loop->first ? $loop->count - 1 : $key - 1 }}" class="btn btn-circle btn-ghost">❮</a>
                                <a href="#slide{{ $loop->last ? 0 : $key + 1 }}" class="btn btn-circle btn-ghost">❯</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Search Bar -->
            <div class="mb-8">
                <form action="{{ route('comics.index') }}" method="GET">
                    <div class="form-control">
                        <div class="relative w-full">
                            <input type="text" name="search" placeholder="{{ __('Search for comics...') }}" class="input input-bordered w-full pr-16" value="{{ request('search') }}" />
                            <button type="submit" class="btn btn-accent absolute top-0 right-0 rounded-l-none h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Favorite Comics -->
            @if($favoriteComics->count() > 0)
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold text-base-content">{{ __('Favorite Comics') }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($favoriteComics as $comic)
                            <div class="card card-compact bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                                <a href="{{ route('comics.show', $comic->id) }}">
                                    <figure><img src="{{ $comic->cover_image ? asset('storage/' . $comic->cover_image) : 'https://via.placeholder.com/300x400.png?text=No+Image' }}" alt="{{ $comic->title }}" class="w-full h-64 object-cover"></figure>
                                    <div class="card-body">
                                        <h2 class="card-title truncate text-base-content">{{ $comic->title }}</h2>
                                        <p class="text-base-content/70">{{ $comic->author ?? 'Unknown Author' }}</p>
                                        <div class="flex items-center space-x-2 text-sm mt-2 text-base-content/70">
                                            <div class="flex items-center space-x-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                                <span>{{ $comic->views }}</span>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>
                                                <span>{{ $comic->favoritedBy()->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Explore Comics -->
            <div class="space-y-4">
                <h3 class="text-2xl font-bold text-base-content">{{ __('Explore Comics') }}</h3>
                @if($comics->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($comics as $comic)
                            <div class="card card-compact bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                                <a href="{{ route('comics.show', $comic->id) }}">
                                    <figure><img src="{{ $comic->cover_image ? asset('storage/' . $comic->cover_image) : 'https://via.placeholder.com/300x400.png?text=No+Image' }}" alt="{{ $comic->title }}" class="w-full h-64 object-cover"></figure>
                                    <div class="card-body">
                                        <h2 class="card-title truncate text-base-content">{{ $comic->title }}</h2>
                                        <p class="text-base-content/70">{{ $comic->author ?? 'Unknown Author' }}</p>
                                        <div class="flex items-center space-x-2 text-sm mt-2 text-base-content/70">
                                            <div class="flex items-center space-x-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                                <span>{{ $comic->views }}</span>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>
                                                <span>{{ $comic->favoritedBy()->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-lg text-base-content/70">No other comics found.</p>
                        @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isTranslator()))
                            <a href="{{ route('comics.create') }}" class="btn btn-accent mt-4">{{ __('Add the First Comic') }}</a>
                        @endif
                    </div>
                @endif
            </div>

        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.carousel .btn-circle[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const carousel = this.closest('.carousel');
                    carousel.scrollTo({
                        left: target.offsetLeft,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
@endpush
</x-app-layout>
