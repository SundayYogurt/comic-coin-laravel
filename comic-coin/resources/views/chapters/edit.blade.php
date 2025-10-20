<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            Edit Chapter - {{ $chapter->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('chapters.update', $chapter->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-base-content">Chapter Number</label>
                        <input type="number" name="chapter_number" value="{{ $chapter->chapter_number }}" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label class="block text-base-content">Title</label>
                        <input type="text" name="title" value="{{ $chapter->title }}" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label class="block text-base-content">Description</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md">{{ $chapter->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-base-content">Price (Coins)</label>
                        <input type="number" name="price" value="{{ $chapter->price }}" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md shadow hover:shadow-lg transition">
                        Update Chapter
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
