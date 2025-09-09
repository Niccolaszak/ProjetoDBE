<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Novo Cargo</h2>
    </x-slot>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-2xl bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('cargos.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nome do Cargo --}}
                <div>
                    <x-input-label for="nome" :value="__('Nome do Cargo')" />
                    <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" required autofocus />
                    <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                </div>

                {{-- Descrição --}}
                <div>
                    <x-input-label for="descricao" :value="__('Descrição')" />
                    <x-text-area id="descricao" name="descricao" class="mt-1 block w-full" rows="3" />
                    <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
                </div>

                {{-- Botões --}}
                <div class="flex justify-between items-center mt-4">
                    <x-secondary-button onclick="window.location='{{ route('cargos.index') }}'" type="button">
                        ← Voltar
                    </x-secondary-button>

                    <x-primary-button type="submit">
                        Salvar
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
