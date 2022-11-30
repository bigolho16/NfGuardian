<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValoresImpostos extends Model
{
    // use HasFactory;
    protected $table = "valores_impostos";
    protected $primaryKey = "codigo";
    protected $fillable = ["codigo_valores_impostos_codigo_nota", "codigo_valores_impostos_codigo_controle_de_imposto", "valor"];


    // Lembrando que esta classe é a filha (que possui a chave estrangeira)
    public function controle_de_nf () {
        return $this->belongsTo('App\Models\ControleDeNF', 'codigo_valores_impostos_codigo_nota', 'codigo');
    }
}
