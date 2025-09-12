<x-aviso type="success" :message="session('success')" />
<x-aviso type="error" :message="session('error')" />

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Painel de Controle</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4" x-data="{ adminOpen: false, livrariaOpen: false }">


        {{-- ===== Livraria ===== --}}
        <div class="bg-white rounded-lg shadow">
            <button 
                @click="livrariaOpen = !livrariaOpen"
                class="w-full flex justify-between items-center p-4 font-semibold text-gray-700 hover:bg-gray-100 rounded-t-lg focus:outline-none"
            >
                Livraria
                <svg :class="{'rotate-180': livrariaOpen}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="livrariaOpen" x-transition class="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'movimentacoes.index'))
                    <a href="{{ route('movimentacoes.index') }}" class="block p-6 bg-gray-50 rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Movimentações</h3>
                        <p class="mt-2 text-gray-500">Gerenciar movimentações</p>
                    </a>
                @endif    
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'estoques.index'))
                    <a href="{{ route('estoques.index') }}" class="block p-6 bg-gray-50 rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Estoque</h3>
                        <p class="mt-2 text-gray-500">Consultar estoque</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'livros.index'))
                    <a href="{{ route('livros.index') }}" class="block p-6 bg-gray-50 rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Livros</h3>
                        <p class="mt-2 text-gray-500">Gerenciar livros</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'generos.index'))
                    <a href="{{ route('generos.index') }}" class="block p-6 bg-gray-50 rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Gêneros</h3>
                        <p class="mt-2 text-gray-500">Gerenciar gêneros</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'fornecedores.index'))
                    <a href="{{ route('fornecedores.index') }}" class="block p-6 bg-gray-50 rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Fornecedores</h3>
                        <p class="mt-2 text-gray-500">Gerenciar fornecedores</p>
                    </a>
                @endif
            </div>
        </div>

        {{-- ===== Administração ===== --}}
        <div class="bg-white rounded-lg shadow">
            <button 
                @click="adminOpen = !adminOpen"
                class="w-full flex justify-between items-center p-4 font-semibold text-gray-700 hover:bg-gray-100 rounded-t-lg focus:outline-none"
            >
                Administração
                <svg :class="{'rotate-180': adminOpen}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="adminOpen" x-transition class="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'permissoes.index'))
                    <a href="{{ route('permissoes.index') }}" class="block p-6 bg-gray-50 rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Permissões</h3>
                        <p class="mt-2 text-gray-500">Gerenciar relação de permissões</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'users.index'))
                    <a href="{{ route('users.index') }}" class="block p-6 bg-gray-50 rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Usuários</h3>
                        <p class="mt-2 text-gray-500">Gerenciar usuários do sistema</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'cargos.index'))
                    <a href="{{ route('cargos.index') }}" class="block p-6 bg-gray-50 rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Cargos</h3>
                        <p class="mt-2 text-gray-500">Gerenciar cargos</p>
                    </a>
                @endif
                @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'setores.index'))
                    <a href="{{ route('setores.index') }}" class="block p-6 bg-gray-50 rounded-lg shadow hover:bg-gray-100 transition">
                        <h3 class="text-lg font-semibold text-gray-700">Setores</h3>
                        <p class="mt-2 text-gray-500">Gerenciar setores</p>
                    </a>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>