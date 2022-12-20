<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FunctionsController;
use App\Models\Empresa;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("autenticacao.login-empresa");
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
        $fc = new FunctionsController();

        // Crie um método de login no sistema
        $cnpj = $request->cnpj;
        $senha = $request->senha;

        //Impedir campos vazios
        if ($cnpj == "") {
            //Preencher os campos automatimente
            $this->gerarSessaoDosInputs ($cnpj, $senha);

            return redirect()->back()->with("error", "Preencha o campo cnpj!");
        }
        if ($senha == "") {
            //Preencher os campos automatimente
            $this->gerarSessaoDosInputs ($cnpj, $senha);

            return redirect()->back()->with("error", "Preencha o campo senha!");
        }

        //Validar cnpj (verificar se é válido)
        $validacnpj = $fc->validaCNPJ($cnpj);
        if ($validacnpj == false) {
            $this->gerarSessaoDosInputs ("", $senha);

            return redirect()->back()->with("error", "O CNPJ fornecido é inválido!");
        }

        //Se o cnpj for válido (==true) ele vai continuar
        $empresa = new Empresa();

        $todasasempresas = $empresa->all();
        
        foreach ($todasasempresas as $empresaespecifica) {
            if ($empresaespecifica->cnpj == $cnpj) {
                //Guarda na variavel o usuário do banco encontrado
                $empresaencontrada = $empresaespecifica;
                
                //Verificar se a senha é válida
                if (password_verify($senha, $empresaencontrada->senha)) {
                    //Inicia a sessão do usuário
                    session_start();
                    $_SESSION["sessao_empresa"] = $empresaencontrada;

                    //Redireciona para página principal
                    return redirect()->route("nota-fiscal.index");
                }else {
                    $this->gerarSessaoDosInputs ($cnpj, "");

                    return redirect()->back()->with("error", "Usuário ou senha inválido!");
                }
                break;
            }

            if ($empresaespecifica == $todasasempresas[count($todasasempresas)-1]) {
                //Caso não encontre nenhum usuário, volte a página
                if ($empresaespecifica->cnpj != $cnpj) {
                    return redirect()->back()->with("error", "Usuário ou senha inválidos!");
                }
            }
        }
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

    public function gerarSessaoDosInputs ($cnpj, $senha) {
        session_start();
        $_SESSION["campo_cnpj"] = $cnpj;
        $_SESSION["campo_senha"] = $senha;
    }
}
