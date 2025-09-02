<x-guest-layout>
    <div class="w-full max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Redefinir Senha</h2>

        <form method="POST" action="{{ route('senha.redefinir') }}">
            @csrf

            <!-- Nova Senha -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Nova senha')" />
                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required
                              autofocus />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar Senha -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar senha')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                              type="password"
                              name="password_confirmation"
                              required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-primary-button>
                    Redefinir Senha
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>