<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ $chapter->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold text-base-content mb-2">{{ $chapter->title }}</h1>
                <p class="text-base-content/80 mb-4">Chapter {{ $chapter->chapter_number }} of
                    {{ $chapter->comic->title ?? 'Unknown Comic' }}</p>
                <p class="text-base-content mb-6">{{ $chapter->description ?? 'No description available.' }}</p>

                @if($chapter->pages->count() > 0)
                    <div class="space-y-0">
                        @foreach($chapter->pages as $page)
                            <div>
                                <img src="{{ asset('storage/' . $page->image_path) }}" alt="Page {{ $page->page_number }}"
                                    class="w-full">
                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-center text-base-content/70">Page {{ $page->page_number }}</p>
                                    @if(auth()->user()?->is_admin)
                                        <div class="flex gap-2">
                                            <a href="{{ route('pages.edit', $page) }}" class="px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-400">Edit</a>
                                            <form method="POST" action="{{ route('pages.destroy', $page) }}" onsubmit="return confirm('Delete this page?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-400">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-100 p-6 rounded text-center text-base-content/70">
                        No pages uploaded yet for this chapter.
                    </div>
                @endif

                {{-- Comments --}}
                <div class="mt-8">
                    <h3 class="text-2xl font-bold text-base-content mb-4">Comments</h3>
                    @auth
                        <form action="{{ route('chapters.comments.store', $chapter) }}" method="POST" class="mb-6">
                            @csrf
                            <input type="text" name="hp" value="" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">
                            <textarea name="content" rows="3" class="textarea textarea-bordered w-full" placeholder="Write a comment..." required maxlength="1000">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <div class="mt-2 text-right">
                                <button type="submit" class="btn btn-primary">Post Comment</button>
                            </div>
                        </form>
                    @else
                        <div class="alert bg-base-200 text-base-content">
                            <span>Please <a class="link link-primary" href="{{ route('login') }}">log in</a> to comment.</span>
                        </div>
                    @endauth

                    <div class="space-y-4">
                        @forelse($chapter->comments as $comment)
                            <div class="bg-base-100 border border-base-300 rounded p-4">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-base-content/70">
                                        <span class="font-semibold text-base-content">{{ $comment->user->name ?? 'User' }}</span>
                                        <span class="ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    @auth
                                        @if(auth()->user()->is_admin || auth()->id() === $comment->user_id)
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Delete this comment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-ghost btn-xs text-error">Delete</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                                <p class="mt-2 whitespace-pre-wrap">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <p class="text-base-content/70">No comments yet. Be the first to comment.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Admin Actions --}}
                @if(auth()->user()?->is_admin)
                    <div class="mt-6 bg-base-200 p-4 rounded-lg shadow-inner">
                        <h3 class="font-bold text-lg mb-4">Admin Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <div>
                                <h4 class="font-semibold mb-2">Upload More Pages</h4>
                                <form action="{{ route('chapters.addPages', $chapter) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                    @csrf
                                    <input type="file" name="images[]" multiple class="file-input file-input-bordered w-full" required>
                                    <button type="submit" class="btn btn-primary w-full">Upload</button>
                                </form>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2">Danger Zone</h4>
                                <form method="POST" action="{{ route('chapters.destroyAllPages', $chapter) }}" onsubmit="return confirm('Are you sure you want to delete ALL pages in this chapter? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error w-full">Delete All Pages</button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endif

                <div class="mt-8">
                    <a href="{{ route('comics.show', $chapter->comic_id) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-md hover:bg-gray-500 hover:shadow-lg focus:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transform hover:scale-105 transition-all ease-in-out duration-150">
                        Back to Comic
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
