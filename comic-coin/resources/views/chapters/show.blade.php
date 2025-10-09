<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $chapter->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $chapter->title }}</h1>
                <p class="text-gray-600 mb-4">Chapter {{ $chapter->chapter_number }} of
                    {{ $chapter->comic->title ?? 'Unknown Comic' }}</p>
                <p class="text-gray-700 mb-6">{{ $chapter->description ?? 'No description available.' }}</p>

                @if($chapter->pages->count() > 0)
                    <div class="space-y-0">
                        @foreach($chapter->pages as $page)
                            <div>
                                <img src="{{ asset('storage/' . $page->image_path) }}" alt="Page {{ $page->page_number }}"
                                    class="w-full">
                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-center text-gray-500">Page {{ $page->page_number }}</p>
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
                    <div class="bg-gray-100 p-6 rounded text-center text-gray-500">
                        No pages uploaded yet for this chapter.
                    </div>
                @endif

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
