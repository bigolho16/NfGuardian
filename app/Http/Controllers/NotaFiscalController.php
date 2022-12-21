<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\ControleDeNF;
use App\Models\ArquivoNota;
use App\Models\SituacaoNota;

class NotaFiscalController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funcionario = new Funcionario();
        $funcionarios = $funcionario->all();

        session_start();
        if (isset($_SESSION['sessao_empresa'])) {
            return view("app", compact("funcionarios"));
        }else {
            return redirect()->route("login.index");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Ativa a sessão caso não esteja ativa
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        //Formatação dos campos:
        //Verificar se código já existe
        $nota_fiscal_codigo = $request->codigo_da_nota;

        $nfs = new ControleDeNF();

        $nfs_desta_empresa = $nfs->where('empresa_proprietaria', $_SESSION["sessao_empresa"]->codigo)->where('nota_fiscal_codigo', $nota_fiscal_codigo)->get();

        if (count($nfs_desta_empresa) > 0) {
            $request->codigo_da_nota = "";
            $this->gerarSessoesDeCamposValidos ($request);

            return redirect()->back()->with("error", "O código de nota já existe, por favor especifique outro!");
        }

        //Organizando os dados antes de inserir:
        if ($request->situacao == "Escolher...") {
            $request->situacao = null;
        }
        if ($request->situacao == "true") {
            $request->situacao = 1;
        }
        if ($request->situacao == "false") {
            $request->situacao = 0;
        }

        //Inserções (seja no banco por parte de 'dados comuns' ou imagens e arquivos):
        //Inserção dos dados comuns (inputs text, valores, etc...)
        $nfs = new ControleDeNF();

        $notainserida = $nfs->create([
            'empresa_proprietaria' => $_SESSION["sessao_empresa"]->codigo,
            'modificado_por' => $request->modificado_por,
            'nota_fiscal_codigo' => $request->codigo_da_nota,
            'data_emissao' => $request->data_de_emissao,
            'prestador_de_servico' => $request->prestador_de_servico,
            'tomada_de_servico' => $request->tomada_de_servico,
            'descricao_de_servico' => $request->descricao_do_servico,
            'valor_do_servico' => $request->valor_do_servico,
            'situacao' => $request->descricao_da_situacao
        ]);

        //Inserção na tabela 'situacao_nf'
        $situacaonf = new SituacaoNota();
        $situacaonf->create([
            'controle_de_nf' => $notainserida->codigo,
            'nota_paga' => $request->situacao,
        ]);

        //Inserção dos arquivos na pasta
        if (!empty($request->arquivo_nota)) {
            $arquivo_nota = $request->file("arquivo_nota");
            if ($arquivo_nota->isValid()) {
                $diretory = $arquivo_nota->store('notas');

                //Inserção do diretório do arquivo no db
                $arquivonf = new ArquivoNota();
                $arquivonf->create([
                    "controle_de_nf" => $notainserida->codigo,
                    "arquivo" => $diretory
                ]);
            }
        }

        // Voltar para a página:
        //Voltar para a página dizendo que foi inserido com sucesso!
        return redirect()->route("nota-fiscal.index")->with("success", "Os dados da nota foram inseridos com sucesso!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function gerarSessoesDeCamposValidos ($req) {
        //Abre uma sessão para cada campo do formulário da página
        $_SESSION["codigo_da_nota"] = $req->codigo_da_nota;
        $_SESSION["data_de_emissao"] = $req->data_de_emissao;
        $_SESSION["prestador_de_servico"] = $req->prestador_de_servico;
        $_SESSION["tomada_de_servico"] = $req->tomada_de_servico;
        $_SESSION["descricao_do_servico"] = $req->descricao_do_servico;
        $_SESSION["valor_do_servico"] = $req->valor_do_servico;
        $_SESSION["situacao"] = $req->situacao;
        $_SESSION["descricao_da_situacao"] = $req->descricao_da_situacao;
        $_SESSION["modificado_por"] = $req->modificado_por;
    }
}
