<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Create Chapter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('chapters.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Comic -->
                    <div class="mb-4">
                        <label for="comic_id" class="block text-base-content">Comic</label>
                        <select name="comic_id" id="comic_id" class="block w-full border-gray-300 rounded-md">
                            @foreach($comics as $comic)
                                <option value="{{ $comic->id }}">{{ $comic->title }}</option>
                            @endforeach
                        </select>
                        @error('comic_id')<p class="text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Chapter number -->
                    <div class="mb-4">
                        <label for="chapter_number" class="block text-base-content">Chapter Number</label>
                        <input type="number" name="chapter_number" id="chapter_number" class="block w-full border-gray-300 rounded-md" required>
                        @error('chapter_number')<p class="text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-base-content">Title</label>
                        <input type="text" name="title" id="title" class="block w-full border-gray-300 rounded-md" required>
                        @error('title')<p class="text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-base-content">Description</label>
                        <textarea name="description" id="description" class="block w-full border-gray-300 rounded-md"></textarea>
                        @error('description')<p class="text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-base-content">Price (Coins)</label>
                        <input type="number" name="price" id="price" class="block w-full border-gray-300 rounded-md" required>
                        @error('price')<p class="text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Pages upload -->
                    <div class="mb-4">
                        <label for="images" class="block text-base-content">Upload Pages</label>
                        <input type="file" name="images[]" id="images" multiple class="block w-full" required>
                        @error('images')<p class="text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Create Chapter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
