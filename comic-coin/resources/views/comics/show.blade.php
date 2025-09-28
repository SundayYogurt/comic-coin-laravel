<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $comic->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Comic Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 md:p-8">
                <div class="md:flex md:gap-8">
                    <!-- Cover Image -->
                    <div class="md:w-1/3 mb-6 md:mb-0">
                        <img src="{{ $comic->cover_image ? asset('storage/' . $comic->cover_image) : 'https://via.placeholder.com/300x450.png?text=No+Image' }}"
                             alt="{{ $comic->title }}"
                             class="w-full rounded-lg shadow-lg">
                    </div>

                    <!-- Comic Details -->
                    <div class="md:w-2/3">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $comic->title }}</h1>
                        <p class="mt-2 text-md text-gray-600">By {{ $comic->author ?? 'Unknown Author' }}</p>
                        <p class="mt-4 text-gray-700">{{ $comic->description ?? 'No description available.' }}</p>

@auth
    <div class="mt-6">
        <form method="POST" action="{{ route('comics.toggleFavorite', $comic) }}">
            @csrf
            <x-primary-button type="submit">
                @if(auth()->user()->favoriteComics->contains($comic->id))
                    Remove from Favorites
                @else
                    Add to Favorites
                @endif
            </x-primary-button>
        </form>
    </div>
@endauth

                        @if(Auth::check() && Auth::user()->is_admin)
                            <div class="mt-6 flex items-center gap-4">
                                <a href="{{ route('comics.edit', $comic) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Edit</a>
                                <form method="POST" action="{{ route('comics.destroy', $comic) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this comic?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Session Status -->
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Chapters List -->
                @if($comic->chapters->count())
                    <div class="mt-8">
                        <h3 class="text-2xl font-semibold mb-4">Chapters</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($comic->chapters as $chapter)
                                <div class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-lg transition">
                                    <h4 class="font-bold text-lg">Chapter {{ $chapter->chapter_number }}: {{ $chapter->title }}</h4>
                                    <p class="text-gray-600 mt-1">{{ $chapter->description }}</p>
                                    <p class="mt-2 text-sm text-gray-500">Price: {{ $chapter->price }} coins</p>
                                    @if(Auth::check() && Auth::user()->is_admin)
                                        <div class="mt-2 flex gap-2">
                                            <a href="{{ route('chapters.edit', $chapter) }}"
                                               class="px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-400">Edit</a>
                                            <form method="POST" action="{{ route('chapters.destroy', $chapter) }}" onsubmit="return confirm('Delete this chapter?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-400">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                    @auth
                                        @if($purchasedChapterIds->contains($chapter->id))
                                            <a href="{{ route('chapters.show', $chapter) }}" class="mt-2 inline-flex items-center px-3 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">Read</a>
                                        @else
                                            <form method="POST" action="{{ route('chapters.purchase', $chapter) }}" class="mt-2">
                                                @csrf
                                                <x-primary-button class="ms-2">
                                                    {{ __('Buy for ') }}{{ $chapter->price }} {{ __('coins') }}
                                                </x-primary-button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="mt-2 inline-block text-gray-700 text-sm">{{ $chapter->price }} Coins</span>
                                        <a href="{{ route('login') }}" class="mt-2 inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">Login to Buy</a>
                                    @endauth
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Add New Chapter Form -->
                @if(Auth::check() && Auth::user()->is_admin)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-2xl font-semibold mb-4">Add New Chapter</h3>
                        <form method="POST" action="{{ route('chapters.store') }}">
                            @csrf
                            <input type="hidden" name="comic_id" value="{{ $comic->id }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="chapter_number" :value="__('Chapter Number')" />
                                    <x-text-input id="chapter_number" class="block mt-1 w-full" type="number" name="chapter_number" :value="old('chapter_number')" required />
                                    <x-input-error :messages="$errors->get('chapter_number')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="title" :value="__('Chapter Title')" />
                                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="price" :value="__('Price (Coins)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', 0)" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ms-4">
                                    {{ __('Add Chapter') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
