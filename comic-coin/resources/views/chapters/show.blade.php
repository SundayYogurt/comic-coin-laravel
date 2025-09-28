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
                    <div class="space-y-6">
                        @foreach($chapter->pages as $page)
                            <div class="bg-gray-100 rounded-lg p-2">
                                <img src="{{ asset('storage/' . $page->image_path) }}" alt="Page {{ $page->page_number }}"
                                    class="w-full rounded">
                                <p class="text-center text-gray-500 mt-2">Page {{ $page->page_number }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-100 p-6 rounded text-center text-gray-500">
                        No pages uploaded yet for this chapter.
                    </div>
                @endif

                {{-- Upload Button for Admin --}}
                @if(auth()->user()?->is_admin)
                    <div class="mt-6 bg-gray-50 p-4 rounded shadow-sm">
                        <h3 class="font-semibold mb-2">Upload Pages</h3>
                        <form action="{{ route('chapters.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="comic_id" value="{{ $chapter->comic_id }}">
                            <input type="hidden" name="chapter_number" value="{{ $chapter->chapter_number }}">
                            <input type="hidden" name="title" value="{{ $chapter->title }}">
                            <input type="hidden" name="description" value="{{ $chapter->description }}">
                            <input type="hidden" name="price" value="{{ $chapter->price }}">
                            <input type="file" name="images[]" multiple class="block w-full mb-2" required>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">
                                Upload Pages
                            </button>
                        </form>

                    </div>
                @endif

                <div class="mt-8">
                    <a href="{{ route('comics.show', $chapter->comic_id) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                        Back to Comic
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
