<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Edit Comic') }}: {{ $comic->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('comics.update', $comic) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $comic->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Author -->
                        <div class="mt-4">
                            <x-input-label for="author" :value="__('Author')" />
                            <x-text-input id="author" class="block mt-1 w-full" type="text" name="author" :value="old('author', $comic->author)" />
                            <x-input-error :messages="$errors->get('author')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $comic->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Translator (Uploader) -->
                        @if(Auth::user()->isAdmin())
                            <div class="mt-4">
                                <x-input-label for="uploader_id" :value="__('Translator')" />
                                <select id="uploader_id" name="uploader_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('uploader_id', $comic->uploader_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('uploader_id')" class="mt-2" />
                            </div>
                        @endif

                        <!-- Current Cover Image -->
                        @if ($comic->cover_image)
                            <div class="mt-4">
                                <x-input-label :value="__('Current Cover Image')" />
                                <img src="{{ asset('storage/' . $comic->cover_image) }}" alt="{{ $comic->title }}" class="mt-2 w-32 h-auto rounded-md shadow-sm">
                            </div>
                        @endif

                        <!-- New Cover Image -->
                        <div class="mt-4">
                            <x-input-label for="cover_image" :value="__('New Cover Image (optional)')" />
                            <x-text-input id="cover_image" class="block mt-1 w-full" type="file" name="cover_image" />
                            <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Update Comic') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
