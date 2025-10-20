<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">
            {{ __('Add New Banner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-base-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-base-100 border-b border-base-300">
                    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="form-control w-full mb-4">
                            <label class="label" for="title">
                                <span class="label-text">{{ __('Title') }}</span>
                            </label>
                            <input type="text" id="title" name="title" placeholder="Banner Title" class="input input-bordered w-full" required value="{{ old('title') }}" />
                            @error('title')
                                <span class="text-error text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-control w-full mb-4">
                            <label class="label" for="description">
                                <span class="label-text">{{ __('Description') }}</span>
                            </label>
                            <textarea id="description" name="description" placeholder="Banner Description" class="textarea textarea-bordered w-full">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-error text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="form-control w-full mb-4">
                            <label class="label" for="image_path">
                                <span class="label-text">{{ __('Banner Image') }}</span>
                            </label>
                            <input type="file" id="image_path" name="image_path" class="file-input file-input-bordered w-full" required />
                             <p class="mt-1 text-sm text-base-content/60">Recommended size: 1280x400px</p>
                            @error('image_path')
                                <span class="text-error text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Link -->
                        <div class="form-control w-full mb-4">
                            <label class="label" for="link">
                                <span class="label-text">{{ __('Link (Optional)') }}</span>
                            </label>
                            <input type="url" id="link" name="link" placeholder="https://example.com" class="input input-bordered w-full" value="{{ old('link') }}" />
                            @error('link')
                                <span class="text-error text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('banners.index') }}" class="btn btn-ghost mr-2">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Save Banner') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
