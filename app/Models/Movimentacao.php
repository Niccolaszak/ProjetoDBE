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
    ];

    public function livro()
    {
        return $this->belongsTo(Livro::class, 'livro_id', 'id');
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
            $estoque->quantidade_disponivel -= $this->quantidade;
            $estoque->quantidade_consumida += $this->quantidade;
        }

        $estoque->ultima_movimentacao = now();
        $estoque->save();
    }

    public function reverterEstoque($original = null)
    {
        $quantidade = $original['quantidade'] ?? $this->quantidade;
        $tipo = $original['tipo'] ?? $this->tipo;

        $estoque = $this->livro->estoque;
        if (!$estoque) return;

        if ($tipo === 'entrada') {
            $estoque->quantidade_disponivel -= $quantidade;
        } elseif ($tipo === 'saida') {
            $estoque->quantidade_disponivel += $quantidade;
            $estoque->quantidade_consumida -= $quantidade;
        }

        $estoque->ultima_movimentacao = now();
        $estoque->save();
    }
}