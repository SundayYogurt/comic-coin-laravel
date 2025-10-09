<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Comic Info -->
            <div class="bg-base-100 shadow-xl rounded-lg p-6 md:p-8 border border-base-300">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Cover Image -->
                    <div class="md:col-span-1">
                        <img src="{{ $comic->cover_image ? asset('storage/' . $comic->cover_image) : 'https://via.placeholder.com/300x450.png?text=No+Image' }}"
                             alt="{{ $comic->title }}"
                             class="w-full rounded-lg shadow-lg">
                    </div>

                    <!-- Comic Details -->
                    <div class="md:col-span-2">
                        <h1 class="text-4xl font-bold">{{ $comic->title }}</h1>
                        <p class="mt-2 text-lg">Author: {{ $comic->author ?? 'Unknown Author' }}</p>
                        <p class="mt-1 text-sm">Translator: {{ $comic->uploader->name ?? 'N/A' }}</p>
                        
                        <div class="mt-4 prose max-w-none">
                            <p>{{ $comic->description ?? 'No description available.' }}</p>
                        </div>

                        @auth
                            <div class="mt-6">
                                <form method="POST" action="{{ route('comics.toggleFavorite', $comic) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline btn-secondary">
                                        @if(auth()->user()->favoriteComics->contains($comic->id))
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                            Remove from Favorites
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                            Add to Favorites
                                        @endif
                                    </button>
                                </form>
                            </div>
                        @endauth

                        @can('update', $comic)
                            <div class="mt-6 flex items-center gap-4">
                                <a href="{{ route('comics.edit', $comic) }}" class="btn btn-info">Edit Comic</a>
                                <form method="POST" action="{{ route('comics.destroy', $comic) }}" onsubmit="return confirm('Are you sure you want to delete this comic?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error">Delete Comic</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Session Status -->
            @if(session('success'))
                <div class="alert alert-success shadow-lg mt-8">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error shadow-lg mt-8">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Chapters List -->
            <div class="mt-8 bg-base-100 shadow-xl rounded-lg p-6 md:p-8 border border-base-300">
                <h3 class="text-3xl font-bold mb-6">Chapters</h3>
                @if($comic->chapters->count())
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Chapter</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                    @can('update', $comic)
                                        <th>Manage</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comic->chapters as $chapter)
                                    <tr class="hover">
                                        <td>
                                            <a href="{{ route('chapters.show', $chapter) }}" class="font-bold">Chapter {{ $chapter->chapter_number }}: {{ $chapter->title }}</a>
                                            <p class="text-sm opacity-70">{{ $chapter->description }}</p>
                                        </td>
                                        <td><span class="badge badge-ghost">{{ $chapter->price }} coins</span></td>
                                        <td>
                                            @auth
                                                @if($purchasedChapterIds->contains($chapter->id) || (Auth::check() && Auth::user()->is_admin))
                                                    <a href="{{ route('chapters.show', $chapter) }}" class="btn btn-primary btn-sm">Read</a>
                                                @else
                                                    <form method="POST" action="{{ route('chapters.purchase', $chapter) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-secondary btn-sm">Buy</button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-accent btn-sm">Login to Buy</a>
                                            @endauth
                                        </td>
                                        @can('update', $comic)
                                            <td>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('chapters.edit', $chapter) }}" class="btn btn-info btn-xs">Edit</a>
                                                    <form method="POST" action="{{ route('chapters.destroy', $chapter) }}" onsubmit="return confirm('Delete this chapter?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-error btn-xs">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No chapters found.</p>
                @endif
            </div>

            <!-- Add New Chapter Form -->
            @can('update', $comic)
                <div class="mt-8 bg-base-100 shadow-xl rounded-lg p-6 md:p-8 border border-base-300">
                    <h3 class="text-3xl font-bold mb-6">Add New Chapter</h3>
                    <form method="POST" action="{{ route('chapters.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="comic_id" value="{{ $comic->id }}">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Chapter Number</span></label>
                            <input type="number" name="chapter_number" class="input input-bordered" required>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Chapter Title</span></label>
                            <input type="text" name="title" class="input input-bordered" required>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Description</span></label>
                            <textarea name="description" class="textarea textarea-bordered" rows="3"></textarea>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Price (Coins)</span></label>
                            <input type="number" name="price" value="0" class="input input-bordered" required>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="btn btn-primary">Add Chapter</button>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>