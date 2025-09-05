<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;
    protected $table = 'permissoes';
    protected $fillable = ['tela_id', 'cargo_id', 'setor_id'];

    public function tela() { return $this->belongsTo(Tela::class); }
    public function cargo() { return $this->belongsTo(Cargo::class); }
    public function setor() { return $this->belongsTo(Setor::class); }
}
