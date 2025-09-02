<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nome Completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Select de Cargo -->
        <div class="mt-4">
            <x-label for="cargo_id" :value="__('Cargo')" />
            <select name="cargo_id" id="cargo_id" required class="block mt-1 w-full">
                <option value="">-- Selecione o cargo --</option>
                @foreach($cargos as $cargo)
                    <option value="{{ $cargo->id }}" {{ old('cargo_id') == $cargo->id ? 'selected' : '' }}>
                        {{ $cargo->nome }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('cargo_id')" class="mt-2" />
        </div>

        <!-- Select de Setor -->
        <div class="mt-4">
            <x-label for="setor_id" :value="__('Setor')" />
            <select name="setor_id" id="setor_id" required class="block mt-1 w-full">
                <option value="">-- Selecione o setor --</option>
                @foreach($setores as $setor)
                    <option value="{{ $setor->id }}" {{ old('setor_id') == $setor->id ? 'selected' : '' }}>
                        {{ $setor->nome }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('setor_id')" class="mt-2" />
        </div>

        <!-- Campo de Salário -->
        <div class="mt-4">
            <x-label for="salario" :value="__('Salário')" />
            <x-input id="salario" class="block mt-1 w-full" type="number" name="salario" value="{{ old('salario') }}" required step="0.01" />
            <x-input-error :messages="$errors->get('salario')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmação de Senha')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
