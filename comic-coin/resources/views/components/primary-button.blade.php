<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center px-6 py-3 bg-indigo-700 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider shadow-md hover:bg-indigo-600 hover:shadow-lg focus:bg-indigo-600 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transform hover:scale-105 transition-all ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
