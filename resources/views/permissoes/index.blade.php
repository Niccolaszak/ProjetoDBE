<x-app-layout>
    <x-slot name="header">Permissões</x-slot>

    <div class="p-6">
        <a href="{{ route('permissoes.create') }}" class="btn btn-primary mb-4">Nova Permissão</a>

        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th>Tela</th>
                    <th>Cargo</th>
                    <th>Setor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissoes as $p)
                <tr>
                    <td>{{ $p->tela->nome }}</td>
                    <td>{{ $p->cargo->nome }}</td>
                    <td>{{ $p->setor->nome }}</td>
                    <td>
                        <form action="{{ route('permissoes.destroy', $p) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Tem certeza?')">Remover</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>