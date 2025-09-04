<x-app-layout>
    <x-slot name="header">Nova Permissão</x-slot>

    <div class="p-6">
        <form action="{{ route('permissoes.store') }}" method="POST">
            @csrf
            <div>
                <label>Tela</label>
                <select name="tela_id" required>
                    @foreach($telas as $t)
                        <option value="{{ $t->id }}">{{ $t->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Cargo</label>
                <select name="cargo_id" required>
                    @foreach($cargos as $c)
                        <option value="{{ $c->id }}">{{ $c->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Setor</label>
                <select name="setor_id" required>
                    @foreach($setores as $s)
                        <option value="{{ $s->id }}">{{ $s->nome }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Salvar</button>
        </form>
    </div>
</x-app-layout>