<x-aviso type="success" :message="session('success')" />
<x-aviso type="error" :message="session('error')" />

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

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
                        <p class="mt-2 text-gray-500">Gerenciar cargos</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'setores.index'))
                    {{-- Setores --}}
                    <a href="{{ route('setores.index') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Setores</h3>
                        <p class="mt-2 text-gray-500">Gerenciar setores</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'users.index'))
                    {{-- Usuários --}}
                    <a href="{{ route('users.index') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Usuários</h3>
                        <p class="mt-2 text-gray-500">Gerenciar usuários do sistema</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'movimentacoes.index'))
                    {{-- Movimentações --}}
                    <a href="{{ route('movimentacoes.index') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Movimentações</h3>
                        <p class="mt-2 text-gray-500">Gerenciar movimentações do sistema</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'estoques.index'))
                    {{-- Estoque --}}
                    <a href="{{ route('estoques.index') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Estoque</h3>
                        <p class="mt-2 text-gray-500">Gerenciar estoque do sistema</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'livros.index'))
                    {{-- Livros --}}
                    <a href="{{ route('livros.index') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Livros</h3>
                        <p class="mt-2 text-gray-500">Gerenciar livros do sistema</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'generos.index'))
                    {{-- Generos --}}
                    <a href="{{ route('generos.index') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Generos</h3>
                        <p class="mt-2 text-gray-500">Gerenciar generos do sistema</p>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
