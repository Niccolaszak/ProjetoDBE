<?php
// app/Models/Movimentacao.php
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

}