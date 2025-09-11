<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    use HasFactory;

    protected $table = 'movimentacoes';

    protected $fillable = [
        'livro_id',
        'quantidade',
        'tipo',
        'responsavel',
        'data_hora',
        'observacao',
        'tipo_relacionamento',
        'relacionamento_id',
        'nome_contato',
        'telefone_contato',
    ];


    public function livro()
    {
        return $this->belongsTo(Livro::class, 'livro_id', 'id');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'relacionamento_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'responsavel', 'id');
    }

    public function getContatoNomeAttribute()
    {
        return $this->nome_contato;
    }

    public function getContatoTelefoneAttribute()
    {
        return $this->telefone_contato;
    }

    protected static function booted()
    {
        static::created(function ($mov) {
            $mov->aplicarEstoque();
        });

        static::deleted(function ($mov) {
            $mov->reverterEstoque();
        });
    }

    public function aplicarEstoque()
    {
        $estoque = $this->livro->estoque()->firstOrCreate([
            'livro_id' => $this->livro_id,
        ], [
            'quantidade_disponivel' => 0,
            'quantidade_consumida' => 0,
        ]);

        if ($this->tipo === 'entrada') {
            $estoque->quantidade_disponivel += $this->quantidade;
        } elseif ($this->tipo === 'saida') {
            if ($estoque->quantidade_disponivel < $this->quantidade) {
                throw new \Exception("Não há estoque suficiente para essa saída.");
            }
            $estoque->quantidade_disponivel -= $this->quantidade;
            $estoque->quantidade_consumida += $this->quantidade;
        }

        $estoque->ultima_movimentacao = now();
        $estoque->save();
    }


    public function reverterEstoque($original = null)
    {
        $quantidade = isset($original['quantidade']) ? $original['quantidade'] : $this->quantidade;
        $tipo = isset($original['tipo']) ? $original['tipo'] : $this->tipo;

        $estoque = $this->livro->estoque()->first();
        if (!$estoque) return;

        if ($tipo === 'entrada') {
            $quantidadeSaida = $estoque->quantidade_consumida;
            if ($quantidadeSaida >= $quantidade) {
                throw new \Exception("Não é possível excluir esta entrada: já existem saídas que utilizam parte dela.");
            }

            $estoque->quantidade_disponivel -= $quantidade;
            if ($estoque->quantidade_disponivel < 0) $estoque->quantidade_disponivel = 0;

        } elseif ($tipo === 'saida') {
            // Só devolve à quantidade disponível se houver realmente estoque consumido
            $estoque->quantidade_consumida -= $quantidade;
            if ($estoque->quantidade_consumida < 0) {
                $quantidade += $estoque->quantidade_consumida; // reduz a quantidade a adicionar
                $estoque->quantidade_consumida = 0;
            }

            $estoque->quantidade_disponivel += $quantidade;
        }

        $estoque->ultima_movimentacao = now();
        $estoque->save();
    }


}