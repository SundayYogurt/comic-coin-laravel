<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Your Uploaded Comics') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('A list of the comics you have uploaded.') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if($comics->count() > 0)
            <ul>
                @foreach($comics as $comic)
                    <li>
                        <a href="{{ route('comics.show', $comic) }}" class="text-lg font-medium text-gray-900 hover:underline">{{ $comic->title }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="mt-1 text-sm text-gray-600">
                {{ __('You have not uploaded any comics yet.') }}
            </p>
        @endif
    </div>
</section>
