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
        'empresa_proprietaria',
        'modificado_por',
        'nota_fiscal_codigo',
        'data_emissao',
        'prestador_de_servico',
        'tomada_de_servico',
        'descricao_de_servico',
        'valor_do_servico',
        'total_liquido',
        'situacao'
    ];
    
    // A tabela filho que no caso é o valores_impostos é que tem a chave estrangeira ( O valor de 'código' é a coluna que está sendo ligada nesta mesma tabela 'ControleDeNF' )
    public function valores_impostos () {
        return $this->hasMany(ValoresImpostos::class, 'codigo_valores_impostos_codigo_nota', 'codigo');
    }

    public function situacao_nf () {
        return $this->hasMany(SituacaoNota::class, 'controle_de_nf', 'codigo');
    }
}
