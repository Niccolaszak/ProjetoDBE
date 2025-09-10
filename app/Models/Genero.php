<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'generos';

    protected $fillable = [
        'genero',
        'descricao_genero',
    ];

    public function livros()
    {
        return $this->hasMany(Livro::class, 'genero_id', 'id');
    }
}