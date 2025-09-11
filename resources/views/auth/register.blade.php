<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Funcionário
        </h2>
    </x-slot>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-2xl bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('register.store') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nome Completo')" />
                    <x-text-input id="name" class="block mt-1 w-full"
                        type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full"
                        type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Select de Cargo -->
                <div>
                    <x-custom-select name="cargo_id" :options="$cargosFiltrados" label="Cargo" placeholder="Selecione o cargo" />
                    <x-input-error :messages="$errors->get('cargo_id')" class="mt-2" />
                </div>

                <!-- Select de Setor -->
                <div>
                    <x-custom-select name="setor_id" :options="$setoresFiltrados" label="Setor" placeholder="Selecione o setor" />
                    <x-input-error :messages="$errors->get('setor_id')" class="mt-2" />
                </div>

                <!-- Campo de Salário -->
                <div>
                    <x-input-label for="salario" :value="__('Salário')" />
                    <x-text-input id="salario" class="block mt-1 w-full"
                        type="number" name="salario"
                        value="{{ old('salario') }}" required step="0.01" />
                    <x-input-error :messages="$errors->get('salario')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-700">
                        Por padrão, a senha do usuário criado será <span class="font-semibold">12345678</span>.
                        No primeiro login, o sistema forçará o usuário a redefini-la.
                    </p>
                </div>

                <!-- Botões -->
                <div class="flex justify-between items-center mt-6">
                    <x-secondary-button onclick="window.location='{{ route('users.index') }}'" type="button">
                        ← Voltar
                    </x-secondary-button>

                    <x-primary-button type="submit">
                        Registrar
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>