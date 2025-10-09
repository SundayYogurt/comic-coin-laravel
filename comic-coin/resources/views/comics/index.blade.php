<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Explore Comics') }}
            </h2>
            @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isTranslator()))
            <a href="{{ route('comics.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-700 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider shadow-md hover:bg-indigo-600 hover:shadow-lg focus:bg-indigo-600 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transform hover:scale-105 transition-all ease-in-out duration-150">
                {{ __('Add New Comic') }}
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($comics->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($comics as $comic)
                                <div class="group bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                                    <a href="{{ route('comics.show', $comic->id) }}">
                                        <img src="{{ $comic->cover_image ? asset('storage/' . $comic->cover_image) : 'https://via.placeholder.com/300x400.png?text=No+Image' }}" alt="{{ $comic->title }}" class="w-full h-64 object-cover group-hover:opacity-80 transition-opacity duration-300">
                                        <div class="p-4">
                                            <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $comic->title }}</h3>
                                            <p class="text-sm text-gray-600">{{ $comic->author ?? 'Unknown Author' }}</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg">No comics found.</p>
                            <a href="{{ route('comics.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-md hover:bg-gray-500 hover:shadow-lg focus:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transform hover:scale-105 transition-all ease-in-out duration-150">
                                {{ __('Add the First Comic') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
