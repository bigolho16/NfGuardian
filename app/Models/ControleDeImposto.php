<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControleDeImposto extends Model
{
    //use HasFactory;
    protected $table = "controle_de_imposto";
    protected $primaryKey = "codigo";
    protected $fillable = [
        "imposto",
        "taxa"
    ];
}
