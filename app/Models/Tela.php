<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tela extends Model
{
    protected $fillable = ['nome', 'rota'];

    public function permissoes()
    {
        return $this->hasMany(Permissao::class);
    }
}