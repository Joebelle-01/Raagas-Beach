@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-sand-200 bg-sand-50/50 focus:border-sea-500 focus:ring-sea-500 rounded-xl shadow-sm py-3 px-4 transition-all duration-200']) }}>
