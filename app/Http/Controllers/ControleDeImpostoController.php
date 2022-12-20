<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControleDeImposto;

class ControleDeImpostoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Ativa a sessão caso não esteja ativa
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['sessao_empresa'])) {
            //Pegar todos os dados e redirecionar
            $cdi = new ControleDeImposto();
            // $allImpostos = $cdi->get();
            $allImpostos = $cdi->where("empresa_proprietaria", $_SESSION['sessao_empresa']->codigo)->limit(20)->get();

            return view("app", compact('allImpostos'));
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
        $imposto = $request->input("imposto");
        $taxa = $request->input("taxa");

        if ($imposto == "" && $taxa == "") {
            return redirect()->back()->with("error", "Por favor, preencha os campos!");
        }

        $this->inserirImpostos($imposto, $taxa);

        return redirect()->route("controle-de-imposto.index")->with("success", "Imposto inserido com sucesso!");

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
        $this->atualizarImposto ($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->apagarImposto ($id);
    }
    
    public function apagarImposto ($id) {
        $cdi = new ControleDeImposto ();
    
        $cdi->destroy($id);

        $success = "success";
        print_r(json_encode("success"));
        return redirect()->route("controle-de-imposto.index")->with("success", "Conteúdo deletado com sucesso!");
    }


    public function atualizarImposto ($request, $id) {
        //Somete uma das duas primeiras variaveis podem estar preenchidas e a que estiver contem o id da linha que deve ser alterada
        $confirmacaoedicaoimposto = $request->input("head");
        $confirmacaoedicaotaxa = $request->input("body");
        $dado = $request->input("dado");

        $cdi = new ControleDeImposto();

        if ($confirmacaoedicaoimposto != "" && $confirmacaoedicaoimposto == $id) { //Imposto
            //Atualizar os dados
            $line = $cdi->find($id);
            $line->imposto = $dado;
            $line->save();

            $success = "success";
            print_r(json_encode("success"));
            return redirect()->route("controle-de-imposto.index")->with("success", "O imposto foi atualizado com sucesso!");
        }
        if ($confirmacaoedicaotaxa != "" && $confirmacaoedicaotaxa == $id) { //Taxa
            //Remover %
            $dadosp = str_replace("%", "", $dado);

            //Atualizar os dados
            $line = $cdi->find($id);
            $line->taxa = $dadosp;
            $line->save();

            $success = "success";
            print_r(json_encode("success"));
            return redirect()->route("controle-de-imposto.index")->with("success", "A taxa foi atualizada com sucesso!");
        }
    }

    public function inserirImpostos($imposto, $taxa) {
        $cdi = new ControleDeImposto();
    
        $cdi->create([
            "imposto" => $imposto,
            "taxa" => $taxa
        ]);
    }
}
