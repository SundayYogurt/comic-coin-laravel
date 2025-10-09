<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('pages.update', $page) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Page Number</span>
                            </label>
                            <input type="number" name="page_number" value="{{ old('page_number', $page->page_number) }}" required class="input input-bordered w-full" />
                            @error('page_number')
                                <label class="label">
                                    <span class="label-text-alt text-red-500">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Current Image</span>
                            </label>
                            <img src="{{ asset('storage/' . $page->image_path) }}" alt="Page {{ $page->page_number }}" class="w-full rounded-lg shadow-md mb-4">
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Replace Image (optional)</span>
                            </label>
                            <input type="file" name="image" class="file-input file-input-bordered w-full" />
                             @error('image')
                                <label class="label">
                                    <span class="label-text-alt text-red-500">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('chapters.show', $page->chapter_id) }}" class="btn">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Page</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>