<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-sea-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-sea-700 hover:scale-[1.02] focus:bg-sea-700 active:bg-sea-800 focus:outline-none focus:ring-2 focus:ring-sea-500 focus:ring-offset-2 transition all duration-200 shadow-lg hover:shadow-sea-500/25']) }}>
    {{ $slot }}
</button>
