<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    protected $fillable = [
        'tipo',
        'razao_social',
        'cpf_cnpj',
        'email',
        'telefone',
        'endereco',
        'cidade',
        'pais',
        'cep',
        'pix',
        'conta_corrente',
        'agencia',
    ];

    public function movimentacoes()
    {
        return $this->hasMany(Movimentacao::class, 'fornecedor_id', 'id');
    }
}