{{-- resources/views/painel.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Painel de Controle</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                    <h3 class="text-lg font-semibold text-gray-700">Dashboard</h3>
                    <p class="mt-2 text-gray-500">Visão geral do sistema</p>
                </a>
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'permissoes.index'))
                    {{-- Permissões --}}
                    <a href="{{ route('permissoes.index') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Permissões</h3>
                        <p class="mt-2 text-gray-500">Gerenciar relação de permissões</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'cargos.index'))
                    {{-- Cargos --}}
                    <a href="{{ route('cargos.index') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Cargos</h3>
                        <p class="mt-2 text-gray-500">Gerenciar cargos da empresa</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'setores.index'))
                    {{-- Setores --}}
                    <a href="#" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Setores</h3>
                        <p class="mt-2 text-gray-500">Gerenciar setores</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'usuarios.index'))
                    {{-- Usuários --}}
                    <a href="{{ route('usuarios.index') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Usuários</h3>
                        <p class="mt-2 text-gray-500">Gerenciar usuários do sistema</p>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
