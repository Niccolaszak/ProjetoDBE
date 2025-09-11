@props([
    'name',
    'options' => [],
    'label' => null,
    'placeholder' => '-- Selecione --',
    'selected' => null,
    'uniqueId' => null
])

@php
    // Gera um ID único se não for passado
    $id = $uniqueId ?? $name . '-' . uniqid();
@endphp

<div x-data="{ 
        open: false, 
        selectedValue: '{{ old($name) ?? '' }}', 
        selectedText: '{{ old($name) ? $options->firstWhere('id', old($name))?->nome : $placeholder }}' 
    }" 
    class="relative w-full"
    @input.window="
        if ($event.detail.name === '{{ $name }}') {
            selectedValue = $event.detail.value;
            selectedText = $event.detail.text;
        }
    "
>
    @if($label)
        {{-- Label agora aponta para o botão, não para o input hidden --}}
        <x-input-label :for="'btn-' . $id" :value="$label" />
    @endif

    <!-- Botão do dropdown -->
    <button type="button"
        id="btn-{{ $id }}"
        class="w-full bg-white py-2 px-4 rounded shadow-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-light flex justify-between items-center"
        aria-haspopup="listbox"
        @click="open = !open">
        <span x-text="selectedText"></span>
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Lista de opções -->
    <ul x-show="open" @click.away="open = false"
        class="absolute w-full bg-white border border-primary-light mt-1 rounded shadow-md z-10 max-h-60 overflow-auto"
        role="listbox"
        :aria-activedescendant="'option-' + selectedValue"
        style="display: none;">
        @foreach($options as $option)
            <li id="option-{{ $option->id }}" class="px-4 py-2 hover:bg-primary-light cursor-pointer"
                role="option"
                @click="
                    selectedValue = '{{ $option->id }}';
                    selectedText = '{{ $option->nome }}';
                    open = false;
                    $dispatch('input', { name: '{{ $name }}', value: '{{ $option->id }}', text: '{{ $option->nome }}' });
                ">
                {{ $option->nome }}
            </li>
        @endforeach
    </ul>

    <!-- Input hidden para envio do form -->
    <input type="hidden" name="{{ $name }}" :value="selectedValue">

    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>