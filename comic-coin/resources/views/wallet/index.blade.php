<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Topup User Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
                @endif

                <form action="{{ route('wallet.add') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="user_id" :value="__('Select User')" />
                        <select name="user_id" id="user_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} (Current: {{ $user->coins }} coins)</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="coins" :value="__('Amount to Add')" />
                        <x-text-input id="coins" name="coins" type="number" min="1" required class="w-full" />
                        <x-input-error :messages="$errors->get('coins')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Add Coins') }}</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
