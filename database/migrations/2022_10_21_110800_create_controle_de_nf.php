<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controle_de_nf', function (Blueprint $table) {
            $table->id("codigo");
            $table->date("data_emissao");
            $table->string("prestador_de_servico", 500);
            $table->string("tomada_de_servico", 500);
            $table->string("descricao_de_servico", 500);
            $table->float("valor_do_servico");
            $table->float("iss");
            $table->float("ir");
            $table->float("pis");
            $table->float("cofins");
            $table->float("csll");
            $table->float("inss");
            $table->float("outras_retencoes");
            $table->float("total_liquido");
            $table->string("situacao", 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controle_de_nf');
    }
};
