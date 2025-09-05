<div class="relative w-full">
    @if($label)
        <x-input-label :for="$name" :value="$label" />
    @endif

    <button type="button"
        class="w-full bg-white py-2 px-4 rounded shadow-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-light flex justify-between items-center"
        onclick="document.getElementById('dropdown-{{ $name }}').classList.toggle('hidden')">
        {{ $placeholder }}
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <ul id="dropdown-{{ $name }}"
        class="absolute w-full bg-white border border-primary-light mt-1 rounded shadow-md hidden z-10 max-h-60 overflow-auto">
        @foreach($options as $option)
            <li class="px-4 py-2 hover:bg-primary-light cursor-pointer" data-value="{{ $option->id }}"
                onclick="document.getElementById('{{ $name }}_hidden').value = {{ $option->id }}; 
                         this.closest('ul').classList.add('hidden'); 
                         this.closest('div').querySelector('button').innerText = '{{ $option->nome }}';">
                {{ $option->nome }}
            </li>
        @endforeach
    </ul>

    <input type="hidden" name="{{ $name }}" id="{{ $name }}_hidden">
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>