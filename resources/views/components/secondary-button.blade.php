<button 
    {{ $attributes->merge([
        'type' => 'button',
        'class' => '
            inline-flex items-center px-4 py-2 
            bg-white border border-secondary
            rounded-md font-semibold text-xs text-secondary uppercase tracking-widest 
            hover:bg-secondary hover:text-white
            focus:bg-secondary focus:text-white
            active:bg-accent active:text-white
            focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2 
            disabled:opacity-25 
            transition ease-in-out duration-150
        '
    ]) }}
>
    {{ $slot }}
</button>