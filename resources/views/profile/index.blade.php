<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div class="w-full min-h-screen bg-gray-50 py-6 px-6">
        <div class="w-full bg-white shadow sm:rounded-lg p-8">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Informações de Perfil') }}
                    </h2>
                </header>

                <div class="mt-6 space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <x-input-label :value="__('Nome')" />
                                <p class="mt-1 w-full rounded-md border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                                    {{ auth()->user()->name }}
                                </p>
                            </div>

                            <div>
                                <x-input-label :value="__('Email')" />
                                <p class="mt-1 w-full rounded-md border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <x-input-label :value="__('Setor')" />
                                <p class="mt-1 w-full rounded-md border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                                    {{ auth()->user()->setor_nome }}
                                </p>
                            </div>

                            <div>
                                <x-input-label :value="__('Cargo')" />
                                <p class="mt-1 w-full rounded-md border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                                    {{ auth()->user()->cargo_nome }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div  class="flex justify-end mt-6 pr-6">
                <x-primary-button :href="route('logout')" class="ms-4" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Sair') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>