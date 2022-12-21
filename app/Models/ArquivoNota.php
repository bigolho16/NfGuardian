<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArquivoNota extends Model
{
    // use HasFactory;
    protected $table = "arquivo_nf";
    protected $primaryKey = "codigo";
    protected $fillable = [
        'controle_de_nf',
        'arquivo',
    ];
}
