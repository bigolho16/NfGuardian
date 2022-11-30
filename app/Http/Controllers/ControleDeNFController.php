<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControleDeNF;
use App\Models\ControleDeImposto;
use App\Models\ValoresImpostos;


class ControleDeNFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session_start();
        if (isset($_SESSION['sessao_empresa'])) {
            // Criar algoritmo que:
            // Ligue tabela nota fiscal a impostos e valores desses impostos (todos estão em tabelas separadas)
            $todoscontroledenf = $this->obterNotaComTudoQueLigaNela ();

            //Retornar colunas de impostos (que é manipulada pelo usuário)
            $todosimpostos = $this->obterCategoriaDeImposto ();

            return view("app", compact('todoscontroledenf', 'todosimpostos'));
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
        //Objetivo: Salvar o dado que vem de um input de uma linha
        $coluna = $request->input('coluna');
        $dado = $request->input('dado');

        $this->inserirEmControleDeNF ($coluna, $dado);

        dd("Veja se inseriu ou não!");
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
        $this->atualizaControleDeNF($request, $id);
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

    // Parte Helper que depois mudarei de lugar
    // [...]

    // Parte Model que depois mudarei de lugar
    public function atualizaControleDeNF ($request, $id) {
        $codigocontrolenotafs = $request->head;
        $colunaControlNotafsORcodImposto = $request->body;
        $dado = $request->dado;

        // Se for numérico: Quero alterar valor de imposto
        // Se não for numérico: Quero alterar valor de uma coluna da tabela controle_de_imposto normalmente
        if (is_numeric($colunaControlNotafsORcodImposto)) {
            //Use: $notalineCE->valores_impostos->valor para acessar a chave estrangeira
            $notalineCE = $this->obterSomenteUmaNotaComTudoQueLigaNela ($codigocontrolenotafs);
            
            $vi = new ValoresImpostos();
            
            if (count($notalineCE->valores_impostos) >= 1) {
                
                $findvi;
                foreach ($notalineCE->valores_impostos as $item_valor_imposto) {
                    if ($item_valor_imposto->codigo_valores_impostos_codigo_nota == $codigocontrolenotafs && $item_valor_imposto->codigo_valores_impostos_codigo_controle_de_imposto == $colunaControlNotafsORcodImposto) {
                        $findvi = $item_valor_imposto;
                    }
                }

                $linhavalorimposto = $vi->find($findvi->codigo);

                if ($linhavalorimposto) {
                    $linhavalorimposto->valor = $dado;
                    $sv = $linhavalorimposto->save();

                    if ($sv) {
                        $this->calcularTotalLiquidoImpostos ();
                    }

                    //Não tem necessidade de atualizar a página!
                    dd($sv);
                }
            }else {
                $codImposto = $colunaControlNotafsORcodImposto;

                $vi->create([
                    "codigo_valores_impostos_codigo_nota" => $codigocontrolenotafs,
                    "codigo_valores_impostos_codigo_controle_de_imposto" => 
                    $codImposto,
                    "valor" => $dado
                ]);

                dd("Dado não existe, crie!");
            }
        }else {
            // dd("Nota: " . $codigocontrolenotafs . " coluna: " . $colunaControlNotafsORcodImposto . " novo-dado: " . $dado);

            //Primeiro: edite os dados da tabela controledenf
            $this->editeEmControleDeNF ($codigocontrolenotafs, $colunaControlNotafsORcodImposto, $dado);

            //Somente faça os calculos do valor do serviço com os impostos "%" para calcular o valor final que é "total líquido" (só vale p/ coluna valor do serviço)
            if ($colunaControlNotafsORcodImposto == "valor_do_servico") {
                $this->calcularTotalLiquidoImpostos($codigocontrolenotafs);
            }

            //Preparar resposta p/ javascript p/ que ele apenas atualize a linha da tabela (sem precisar atualizar a página)
            $allnota =  $this->obterSomenteUmaNotaComTudoQueLigaNela ($codigocontrolenotafs);

            $linhaalterada = json_encode($allnota);
            $valores_impostos = json_encode($allnota->valores_impostos);

            $error = 0; //error=1 == true / error=0 == false
            print_r(json_encode(compact("linhaalterada","valores_impostos", "error")));
        }
    }

    public function calcularTotalLiquidoImpostos ($idlinha) {
        //Saber a linha a se calcular (inclusive a c/ chave estrangeira)
        $linhadanota = $this->obterSomenteUmaNotaComTudoQueLigaNela($idlinha);
        
        //Fazer os calculos para descontar dos impostos, pois houve alteração no valor do serviço
        
        $cdi = new ControleDeImposto();
        $allcdi = $cdi->all();

        $vi = new ValoresImpostos();

        $calculoTotal = 0;
        foreach ($linhadanota->valores_impostos as $item_valor_imposto) {

            foreach ($allcdi as $xcdi) {
                if ($item_valor_imposto->codigo_valores_impostos_codigo_controle_de_imposto == $xcdi->codigo) {
                    $calculofeito = $linhadanota->valor_do_servico * $xcdi->taxa / 100;

                    //P/ posterior adicionamento na coluna valor_total
                    $calculoTotal += $calculofeito;
                    
                    // echo ($item_valor_imposto->valor) . "<br> seu calculo:" . $calculofeito . "<br>";

                    $linhavi = $vi->find($item_valor_imposto->codigo);
                    $linhavi->valor = $calculofeito;
                    $linhavi->save();
                    break;
                }
            }
        }

        $totalLiquido = $linhadanota->valor_do_servico - $calculoTotal;

        $this->editeEmControleDeNF($idlinha, "total_liquido", $totalLiquido);

        // dd($totalLiquido);
    }

    public function obterSomenteUmaNotaComTudoQueLigaNela ($id) {
        $cdnf = new ControleDeNF();
        $notaline = $cdnf->find($id);
        $notalineCE = $notaline;
        return $notalineCE;
    }

    public function obterNotaComTudoQueLigaNela () {
        //Montar um script inprovisado (gambiarra), para pegar tds elementos com todas suas chaves estrangeiras
        $controledenf = new ControleDeNF();
        $todoscontroledenf = $controledenf->all();
        $notaWithChEstrangs = [];
        foreach ($todoscontroledenf as $v) {
            array_push($notaWithChEstrangs, $controledenf->find($v->codigo)); 
        }
        return ($notaWithChEstrangs);
    }

    public function obterCategoriaDeImposto () {
        $cdi = new ControleDeImposto ();
        
        $allcdi = $cdi->all();

        return $allcdi;
    }
    
    public function editeEmControleDeNF ($id, $coluna, $novodado) {
        $controlnf = new ControleDeNF();
        $linhaasereditada = $controlnf->find($id);
        $linhaasereditada[$coluna] = $novodado;
        $linhaasereditada->save();

        // dd('Os dados foram alterados com sucesso!');
    }

    public function inserirEmControleDeNF ($coluna, $dado) {
        $controlnf = new ControleDeNF();

        $controlnf->create([
            $coluna => $dado
        ]);
    }
}
