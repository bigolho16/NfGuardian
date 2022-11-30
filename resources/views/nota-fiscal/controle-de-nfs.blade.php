@push("estilo-controle-de-nfs")
<link rel="stylesheet" href="{{asset('css/controle-de-nfs.css')}}">
@endpush

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

        @forelse ($todoscontroledenf as $controledenf)
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

{{-- @foreach ($todoscontroledenf as $item)
    {{($item->valores_impostos)}}

@endforeach --}}

@endsection