<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nova Permissão</h2>
    </x-slot>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-2xl bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('permissoes.store') }}" method="POST" class="space-y-6">
                @csrf

                <x-custom-select name="tela_id" :options="$telasFiltradas" label="Tela" placeholder="Selecione a tela" />
                <x-custom-select name="cargo_id" :options="$cargosFiltrados" label="Cargo" placeholder="Selecione o cargo" />
                <x-custom-select name="setor_id" :options="$setoresFiltrados" label="Setor" placeholder="Selecione o setor" />


                {{-- Botões --}}
                <div class="flex justify-between items-center mt-4">
                    <x-secondary-button onclick="window.location='{{ route('permissoes.index') }}'" type="button">
                        ← Voltar
                    </x-secondary-button>

                    <x-primary-button type="submit">
                        Salvar
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>

    <script>
        const button = document.getElementById('dropdownButton');
        const menu = document.getElementById('dropdownMenu');
        const hiddenInput = document.getElementById('tela_id_hidden');

        // Abrir/fechar dropdown
        button.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Selecionar opção
        menu.querySelectorAll('li').forEach(item => {
            item.addEventListener('click', () => {
                button.firstChild.textContent = item.textContent;
                hiddenInput.value = item.dataset.value;
                menu.classList.add('hidden');
            });
        });

        // Fechar dropdown se clicar fora
        document.addEventListener('click', (e) => {
            if (!button.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
