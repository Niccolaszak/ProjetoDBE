@props(['disabled' => false])

<input 
    @disabled($disabled) 
    {{ $attributes->merge([
        'class' => '
            border border-gray-300 
            rounded-md shadow-sm 
            focus:border-primary focus:ring-primary 
            focus:bg-primary/10
            text-gray-900 placeholder-gray-400 
            disabled:opacity-50 disabled:cursor-not-allowed 
            transition ease-in-out duration-150
        '
    ]) }}
>
