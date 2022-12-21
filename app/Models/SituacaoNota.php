<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacaoNota extends Model
{
    // use HasFactory;
    protected $table = "situacao_nf";
    protected $primaryKey = "codigo";
    protected $fillable = [
        'controle_de_nf',
        'nota_paga',
    ];

    // Lembrando que esta classe é a filha (que possui a chave estrangeira)
    public function controle_de_nf () {
        return $this->belongsTo(ControleDeNF::class, 'controle_de_nf', 'codigo');
    }
}
