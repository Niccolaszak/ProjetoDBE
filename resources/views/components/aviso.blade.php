@props([
    'type' => 'success', // success | error
    'message' => '',
])

@if($message)
<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 1500)"
    x-transition
    class="fixed inset-0 flex items-center justify-center z-50"
>
    <!-- Toast centralizado -->
    <div @class([
            'flex justify-between items-center w-full max-w-lg px-6 py-4 rounded-xl shadow-2xl border text-lg',
            'bg-green-500 text-white border-green-600' => $type === 'success',
            'bg-red-500 text-white border-red-600' => $type === 'error',
        ])>
        <span class="font-medium">{{ $message }}</span>
        <button @click="show = false" class="ml-4 text-white font-bold text-2xl">&times;</button>
    </div>
</div>
@endif