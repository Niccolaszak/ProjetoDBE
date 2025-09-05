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

                {{-- Permissões --}}
                <a href="{{ route('permissoes.index') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                    <h3 class="text-lg font-semibold text-gray-700">Permissões</h3>
                    <p class="mt-2 text-gray-500">Gerenciar permissões de usuários</p>
                </a>

                {{-- Cargos --}}
                <a href="#" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                    <h3 class="text-lg font-semibold text-gray-700">Cargos</h3>
                    <p class="mt-2 text-gray-500">Gerenciar cargos da empresa</p>
                </a>

                {{-- Setores --}}
                <a href="#" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                    <h3 class="text-lg font-semibold text-gray-700">Setores</h3>
                    <p class="mt-2 text-gray-500">Gerenciar setores</p>
                </a>

                {{-- Usuários --}}
                <a href="#" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                    <h3 class="text-lg font-semibold text-gray-700">Usuários</h3>
                    <p class="mt-2 text-gray-500">Gerenciar usuários do sistema</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
