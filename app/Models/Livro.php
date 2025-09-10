<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $table = 'livros';

    protected $fillable = [
        'titulo',
        'autor',
        'genero_id',
        'descricao_livro',
    ];

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'genero_id', 'id');
    }

    public function movimentacoes()
    {
        return $this->hasMany(Movimentacao::class, 'livro_id', 'id');
    }

    public function estoque()
    {
        return $this->hasOne(Estoque::class, 'livro_id', 'id');
    }
}