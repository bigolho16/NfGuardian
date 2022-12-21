<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Http\Controllers\FunctionsController;

class ConfiguracoesController extends Controller
{
    public $empresa;
    public $funcionario;

    public function __construct () {
        $this->empresa = new Empresa();
        $this->funcionario = new Funcionario();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session_start();
        if (isset($_SESSION['sessao_empresa'])) {
            //Listar todos os funcionários da empresa
            $todosfuncionarios = $this->funcionario->where('codigoEmpresa', $_SESSION['sessao_empresa']->codigo)->limit(20)->get();

            return view("settings.configuracoes", compact("todosfuncionarios"));
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
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($request->nome) && isset($request->cargo)) {
            $nome = $request->nome;
            $cargo = $request->cargo;

            $this->funcionario->create([
                "codigoEmpresa" => $_SESSION["sessao_empresa"]->codigo,
                "nome" => $nome,
                "cargo" => $cargo
            ]);

            return redirect()->back()->with("success", "Funcionário inserido com sucesso!");
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
        if (isset($request->nome) && isset($request->cnpj)) {
            $codigo = $id;
            $nome = $request->nome;
            $cnpj = $request->cnpj;

            //Validar para ver se os campos estão corretos
            $fc = new FunctionsController();

            $seocnpjevalido = $fc->validaCNPJ($cnpj);

            if ($seocnpjevalido == false) {
                $this->gerarSessaoDeNomeCnpj ($nome, $cnpj);

                return redirect()->back()->with("error", "O CNPJ fornecido é inválido!");
            }

            //Alterar os dados no db

            $empresaencontrada = $this->empresa->find($codigo);
            
            $empresaencontrada->nome = $nome;
            $empresaencontrada->cnpj = $cnpj;
            $empresaencontrada->save();

            //Alterar os dados da sessão atual
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            if (isset($_SESSION["sessao_empresa"])) {
                $_SESSION["sessao_empresa"]->nome = $nome;
                $_SESSION["sessao_empresa"]->cnpj = $cnpj;
            }

            return redirect()->back()->with("success", "Os dados foram alterados com sucesso!");
        }

        if (isset($request->senha_antiga) && isset($request->nova_senha)) {
            $codigo = $id;
            $senha_antiga = $request->senha_antiga;
            $nova_senha = $request->nova_senha;

            //Verificar se senha antiga bate no sistema
            $empresaencontrada = $this->empresa->find($codigo);

            if (!password_verify($senha_antiga, $empresaencontrada->senha)) {
                return redirect()->back()->with("error", "Por favor, defina uma senha antiga correta!");
            }

            //Alterar a senha
            $empresaencontrada->senha = password_hash($nova_senha, PASSWORD_DEFAULT);
            $empresaencontrada->save();

            //Alterar na sessao atual
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            if (isset($_SESSION["sessao_empresa"])) {
                $_SESSION["sessao_empresa"]->senha = $nova_senha;
            }

            return redirect()->back()->with("success", "A senha foi alterada com sucesso!");
        }

        if (isset($request->nome) && isset($request->cargo)) {
            $codigo = $id;
            $nome = $request->nome;
            $cargo = $request->cargo;
        
            //Editar o funcionário
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $funcionarioencontrado = $this->funcionario->find($codigo);

            $funcionarioencontrado->nome = $nome;
            $funcionarioencontrado->cargo = $cargo;
            $funcionarioencontrado->save();

            return redirect()->route("configuracoes.index")->with("success", "Os dados foram alterados com sucesso!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Apagar o funcionario do mapa
        $funcionarioencontrado = $this->funcionario->findOrFail($id);
        $funcionarioencontrado->delete();
        
        return redirect()->route("configuracoes.index")->with("success", "Funcionário excluído com sucesso!");
    }

    public function gerarSessaoDeNomeCnpj ($nome, $cnpj) {
        session_start();
        $_SESSION["campo_nome"] = $nome;
        $_SESSION["campo_cnpj"] = $cnpj;
    }
}
