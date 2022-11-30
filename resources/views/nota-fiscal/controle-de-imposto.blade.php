@push('estilo-controle-de-imposto')
    <link rel="stylesheet" href="{{asset('css/controle-de-imposto.css')}}">
@endpush

@section("form-controle-de-imposto")
@if (session("success"))
    <div class="alert alert-success">
        {{session("success")}}
    </div>
@endif
@if (session("error"))
    <div class="alert alert-danger">
        {{session("error")}}
    </div>
@endif


<form action="{{route('controle-de-imposto.store')}}" class="formulario-controle-de-imposto" method="POST">
    {{-- Proteção --}}
    @csrf
    
    <h4>Inserção de impostos</h4>

    <label for="imposto">Imposto:</label>
    <input type="text" name="imposto" placeholder="nome do imposto">

    <label for="taxa">Taxa %:</label>
    <input type="text" name="taxa" placeholder="">

    <input type="submit" value="salvar">
</form>
@endsection

@section("tabela-controle-de-imposto")
<table class="tabela-controle-de-imposto">

    <thead class="cabecalho-alteravel">
        <tr>
        @forelse ($allImpostos as $imposto)
            <th class="head-codigo-{{$imposto->codigo}}">{{$imposto->imposto}}</th>
        @empty
            
        @endforelse
        </tr>
    </thead>

    <tbody class="corpo-alteravel">
        <tr>
        @forelse ($allImpostos as $imposto)
            <td class="body-codigo-{{$imposto->codigo}}">{{$imposto->taxa}}%</td>
        @empty
            
        @endforelse
        </tr>
    </tbody>
    
    {{-- <thead>
        <tr>
            <th>ISS</th>
            <th>IR</th>
            <th>PIS</th>
            <th>COFINS</th>
            <th>CSLL</th>
            <th>INSS</th>
            <th>OUTRAS RETENÇÕES</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>3,00%</td>
            <td>1,50%</td>
            <td>0,66%</td>
            <td>3,00%</td>
            <td>1,00%</td>
            <td>11,0%</td>
            <td>0,00%</td>
        </tr>
    </tbody> --}}
</table>
@endsection