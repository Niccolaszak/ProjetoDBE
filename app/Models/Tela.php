<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tela extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'rotas'];

    protected $casts = [
        'rotas' => 'array',
    ];

    public function permissoes()
    {
        return $this->hasMany(Permissao::class);
    }
}