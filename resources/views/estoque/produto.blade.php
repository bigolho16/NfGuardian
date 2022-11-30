@push('estilo-produto')
    <link rel="stylesheet" href="{{asset('css/produto.css')}}">
@endpush

@section("tabela-principal-de-produto")
<table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">Código</th>
        <th scope="col">Nome</th>
        <th scope="col">Tamanho</th>
        <th scope="col">Peso</th>
        <th scope="col">Preço de Venda</th>
        <th scope="col">Preço médio de Compra</th>
        <th scope="col">Lucro estimado por Unidade</th>
        <th scope="col">% Lucro</th>
        <th scope="col">Estoque Atual</th>
        <th scope="col">Valor do Estoque Atual</th>
        <th scope="col">Descrição</th>
      </tr>
    </thead>
    {{-- <tbody>
      <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
      </tr>
      <tr>
        <th scope="row">3</th>
        <td colspan="2">Larry the Bird</td>
        <td>@twitter</td>
      </tr>
    </tbody> --}}
</table>
@endsection

{{-- Formulário para o modal --}}
@section("formulario-para-insert")
{{-- Este formulário é deste link --> https://getbootstrap.com.br/docs/4.1/components/forms/#campos-de-formul%C3%A1rio --}}

<form>
    <div class="div-pai-modal-edicao">
        <div class="form-group">
        <label for="exampleFormControlInput1">Código</label>
        <input type="text" class="form-control" placeholder="Código de identificação do produto">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nome</label>
            <input type="text" class="form-control" placeholder="Nome do Produto">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Tamanho</label>
            <input type="text" class="form-control" placeholder="Tamanho do Produto">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Peso</label>
            <input type="text" class="form-control" placeholder="Peso do Produto">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Preço de Venda</label>
            <input type="text" class="form-control" placeholder="Preço da Venda do Produto">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Preço Médio de Compra</label>
            <input type="text" class="form-control" placeholder="Preço Médio de Compra do Produto">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Lucro Estimado por Unidade</label>
            <input type="text" class="form-control" placeholder="Lucro Por Unidade do Produto">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">% Lucro</label>
            <input type="text" class="form-control" placeholder="Lucro da Venda em Porcentagem">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Estoque Atual</label>
            <input type="text" class="form-control" placeholder="Quantidade do Produto em Estoque">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Valor do Estoque Atual</label>
            <input type="text" class="form-control" placeholder="Soma de Todo o Estoque deste Produto">
        </div>

        <div class="form-group">
        <label for="exampleFormControlTextarea1">Descrição</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Mais detalhes sobre este produto"></textarea>
        </div>
    </div>
</form>
@endsection