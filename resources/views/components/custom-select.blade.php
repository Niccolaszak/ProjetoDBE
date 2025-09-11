@props([
    'name',
    'options' => [],
    'label' => null,
    'placeholder' => '-- Selecione --',
    'selected' => null,
    'uniqueId' => null
])
<div x-data="{ open: false, selectedValue: '{{ $selected }}', selectedText: '{{ $selected ? $options->firstWhere('id', $selected)?->nome : $placeholder }}' }" class="relative w-full">
    @if($label)
        <x-input-label :for="$name" :value="$label" />
    @endif

    <!-- Botão do dropdown -->
    <button type="button"
        class="w-full bg-white py-2 px-4 rounded shadow-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-light flex justify-between items-center"
        @click="open = !open">
        <span x-text="selectedText"></span>
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Lista de opções -->
    <ul x-show="open" @click.away="open = false"
        class="absolute w-full bg-white border border-primary-light mt-1 rounded shadow-md z-10 max-h-60 overflow-auto">
        @foreach($options as $option)
            <li class="px-4 py-2 hover:bg-primary-light cursor-pointer"
                @click="selectedValue = '{{ $option->id }}'; selectedText = '{{ $option->nome }}'; open = false;">
                {{ $option->nome }}
            </li>
        @endforeach
    </ul>

    <!-- Input hidden para envio do form -->
    <input type="hidden" name="{{ $name }}" :value="selectedValue">
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>