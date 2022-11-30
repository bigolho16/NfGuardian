<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControleDeNF extends Model
{
    // use HasFactory;
    protected $table = "controle_de_nf";
    protected $primaryKey = "codigo";
    protected $fillable = [
        'nota_fiscal_codigo',
        'data_emissao',
        'prestador_de_servico',
        'tomada_de_servico',
        'descricao_de_servico',
        'valor_do_servico',
        'iss',
        'ir',
        'pis',
        'cofins',
        'csll',
        'inss',
        'outras_retencoes',
        'total_liquido',
        'situacao'
    ];
    
    // A tabela filho que no caso é o valores_impostos é que tem a chave estrangeira
    public function valores_impostos () {
        return $this->hasMany('App\Models\ValoresImpostos', 'codigo_valores_impostos_codigo_nota', 'codigo');
    }
}
