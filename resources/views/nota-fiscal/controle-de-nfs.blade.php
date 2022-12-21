@push("estilo-controle-de-nfs")
<link rel="stylesheet" href="{{asset('css/controle-de-nfs.css')}}">
@endpush

@push('script-controle-de-nfs')
<script src="{{asset('js/controle-de-nfs.js')}}"></script>
@endpush

@section('campo-de-pesquisa-para-tabela')

{{-- <h4>Notas Fiscais:</h4> --}}

<nav class="navbar navbar-light bg-light nav-bar-padding-bottom nav-bar-fonte-ideal">

    <form action="{{ route('controle-de-nfs.store') }}" method="POST">
        <?php
            $tchecked = ""; $nchecked = ""; $nnchecked = ""; $periodo_inicial = ""; $periodo_final = ""; $codigo_nota = "";
            if (isset($_SESSION['todas_as_notas'])) {
                $tchecked = "checked='checked'";
            } else if (isset($_SESSION['notas_pagas'])) {
                $nchecked = "checked='checked'";
            } else if (isset($_SESSION['notas_nao_pagas'])) {
                $nnchecked = "checked='checked'";
            } else {
                if (empty($_SESSION['codigo_nota'])) {
                    $tchecked = "checked='checked'";
                }
            }

            if (isset($_SESSION['periodo_inicial'])) {
                $periodo_inicial = "value=".$_SESSION['periodo_inicial']."";
            }
            if (isset($_SESSION['periodo_final'])) {
                $periodo_final = "value=".$_SESSION['periodo_final']."";
            }

            if (isset($_SESSION['codigo_nota'])) {
                $codigo_nota = $_SESSION['codigo_nota'];
            }
        ?>

        @csrf
        <label for="check-nota-paga">Todas as notas</label>
        <a class="navbar-brand"><input name="todas_as_notas" class="check-notas-pagas-ou-nao" id="check-nota-paga" type="checkbox" {{$tchecked}} onclick="marcaDesmarca(this)"></a>
        <label for="check-nota-paga">Nota paga</label>
        <a class="navbar-brand"><input name="notas_pagas" class="check-notas-pagas-ou-nao" id="check-nota-paga" type="checkbox" {{$nchecked}} onclick="marcaDesmarca(this)"></a>
        <label for="check-nota-nao-paga">Não paga</label>
        <a class="navbar-brand"><input name="notas_nao_pagas" class="check-notas-pagas-ou-nao" id="check-nota-nao-paga" type="checkbox" {{$nnchecked}} onclick="marcaDesmarca(this)"></a>

        <label for="inp-search-data">Período entre</label>
        <a class="navbar-brand"><input name="periodo_inicial" class="form-control mr-sm-2" type="date" {{$periodo_inicial}} placeholder="Search" id="inp-search-data" required oninvalid="this.setCustomValidity('Determine um período inicial de pesquisa!')" oninput="setCustomValidity('')"></a>
        <a class="navbar-brand"><input name="periodo_final" class="form-control mr-sm-2" type="date" {{$periodo_final}} placeholder="Search" id="inp-search-data" required oninvalid="this.setCustomValidity('Determine um período final de pesquisa!')" oninput="setCustomValidity('')"></a>
        <button class="btn btn-primary my-2 my-sm-0" type="submit">Buscar</button>
    </form>
        
    
    <form class="form-inline" action="{{ route('controle-de-nfs.store') }}" method="POST">
        @csrf
        <input class="form-control mr-sm-2" name="codigo_nota" type="search" value='{{$codigo_nota}}' placeholder="Código da Nota" aria-label="Search">
        <button class="btn btn-primary my-2 my-sm-0" type="submit">Buscar</button>
    </form>
</nav>

<?php
    unset($_SESSION['todas_as_notas'], $_SESSION['notas_pagas'], $_SESSION['notas_nao_pagas'], $_SESSION['periodo_inicial'], $_SESSION['periodo_final'], $_SESSION['codigo_nota']);
?>
@endsection

@section('tabela-controle-de-nfs')

<table class="tabela-controle-nfs">
    <thead>
        <tr>
            <th scope="col">Nota Fiscal (Cód.)</th>
            <th scope="col">Data emissão</th>
            <th scope="col">Prestador de serviço</th>
            <th scope="col">Tomada de serviço</th>
            <th scope="col">Descrição de serviço</th>
            <th scope="col">Valor do serviço</th>

            <?php
            $codsImposto = [];
            ?>
            @forelse ($todosimpostos as $imposto)
            <?php
                array_push($codsImposto, $imposto->codigo);
            ?>

            <th>{{ $imposto->imposto }} {{ $imposto->taxa }}%</th>
            @empty
                
            @endforelse

            <th scope="col">Total Líquido</th>
            <th scope="col">Situação</th>
        </tr>
    </thead>
    <tbody class="corpo-alteravel">
        
        @forelse ($notasfiltradas as $controledenf)
        <?php
            $data = $controledenf->data_emissao;
            if(count(explode("/",$data)) > 1){
                $controledenf->data_emissao = implode("-",array_reverse(explode("/",$data)));
            }elseif(count(explode("-",$data)) > 1){
                $controledenf->data_emissao = implode("/",array_reverse(explode("-",$data)));
            }
        ?>

        <tr class="line-{{$controledenf->codigo}}">
            <td class="body-codigo-{{$controledenf->codigo}} nota_fiscal_codigo">{{$controledenf->nota_fiscal_codigo}}</td>
            <td class="body-codigo-{{$controledenf->codigo}} data_emissao">{{$controledenf->data_emissao}}</td>
            <td class="body-codigo-{{$controledenf->codigo}} prestador_de_servico">{{$controledenf->prestador_de_servico}}</td>
            <td class="body-codigo-{{$controledenf->codigo}} tomada_de_servico">{{$controledenf->tomada_de_servico}}</td>
            <td class="body-codigo-{{$controledenf->codigo}} descricao_de_servico">{{$controledenf->descricao_de_servico}}</td>
            <td class="body-codigo-{{$controledenf->codigo}} valor_do_servico">{{$controledenf->valor_do_servico}}</td>
            {{-- Parte dos valores dos impostos (está como chave estrangeira; tbm lembrando que imposto é manipulada pelo usuário) --}} 
            @forelse ($codsImposto as $codimposto)
                {{-- @if (isset($controledenf->valores_impostos)) --}}
                    @if (count($controledenf->valores_impostos) >= 1)
                        @forelse ($controledenf->valores_impostos as $itemvalorimposto)

                            @if ($itemvalorimposto->codigo_valores_impostos_codigo_nota  == $controledenf->codigo && $itemvalorimposto->codigo_valores_impostos_codigo_controle_de_imposto == $codimposto)
                                <td  class="body-codigo-{{$controledenf->codigo}} cod-imposto-{{$codimposto}}">{{$itemvalorimposto->valor}}</td>
                                @break
                            @else
                                @if($controledenf->valores_impostos->last()->codigo == $itemvalorimposto->codigo)
                                    <td  class="body-codigo-{{$controledenf->codigo}} cod-imposto-{{$codimposto}}"></td>
                                @endif
                            @endif
                            {{-- @if ($codsImposto[count($codsImposto)-1] == $codimposto)
                                @break
                            @endif --}}
                        @empty
                        @endforelse
                    
                    @else
                    <td class="body-codigo-{{$controledenf->codigo}} cod-imposto-{{$codimposto}}"></td>
                    @endif
                {{-- @endif --}}



                {{-- @if (isset($controledenf->valores_impostos->codigo))
                    @if ($controledenf->valores_impostos->codigo_valores_impostos_codigo_controle_de_imposto == $codimposto)
                        <td class="body-codigo-{{$controledenf->codigo}} cod-imposto-{{$codimposto}}">
                            {{$controledenf->valores_impostos->valor}}
                        </td>
                    @else
                    <td class="body-codigo-{{$controledenf->codigo}} cod-imposto-{{$codimposto}}"></td>
                    @endif
                @else
                <td class="body-codigo-{{$controledenf->codigo}} cod-imposto-{{ $codimposto }}"></td>
                @endif --}}
            @empty

            {{-- criar script que crie tds de com tantos que tem no banco (impostos) --}}
                <td></td>
            @endforelse

            <td class="body-codigo-{{$controledenf->codigo}} total_liquido">{{$controledenf->total_liquido}}</td>
            <td class="body-codigo-{{$controledenf->codigo}} situacao">{{$controledenf->situacao}}</td>
        </tr>
        @empty
            
        @endforelse
    </tbody>
</table>

{{-- @foreach ($notasfiltradas as $item)
    {{($item->valores_impostos)}}

@endforeach --}}

@endsection