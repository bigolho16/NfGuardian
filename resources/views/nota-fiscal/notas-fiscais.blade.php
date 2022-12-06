@push('estilo-notas-fiscais')
    <link rel="stylesheet" href="{{asset('css/notas-fiscais.css')}}">
@endpush

@push('script-notas-fiscais')
<script src="{{asset('js/notas-fiscais.js')}}"></script>
@endpush

@section('formulario-de-insercao-notas')

<h5 style="padding: 10px;">Inserção das notas fiscais:</h5>

<div class="div-pai-formulario-insercao-notas">
<form>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputEmail4">Código da nota</label>
            <input type="text" class="form-control" id="inputEmail4" placeholder="Um identificador para nota fiscal">
        </div>
        <div class="form-group col-md-6">
            <label for="inputPassword4">Data de emissão</label>
            <input type="date" class="form-control" id="inputPassword4" placeholder="Data de emissão da nota fiscal">
        </div>
    </div>
    <div class="form-group">
        <label for="inputAddress">Prestador do serviço</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="Empresa prestadora do serviço">
    </div>
    <div class="form-group">
        <label for="inputAddress2">Tomada de serviço</label>
        <input type="text" class="form-control" id="inputAddress2" placeholder="Para qual empresa foi prestado o serviço">
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="inputCity">Descrição do serviço</label>
            <div class="form-group">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Exemplo: Referente ao serviço de manutenção corretiva..."></textarea>
            </div>
        </div>
        <div class="form-group col-md-3">
            <label for="inputAddress">Valor do serviço (R$)</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="Valor cobrado no serviço" onKeyPress="return(moeda(this,'.',',',event))">
        </div>
        <div class="form-group col-md-3">
        <label for="inputState">Situação</label>
        <select id="inputState" class="form-control">
            <option selected>Escolher...</option>
            <option>Nota paga</option>
            <option>Nota não paga (andamento)</option>
        </select>
        </div>
        <div class="form-group col-md-3">
            <label for="inputState">Descrição da situação</label>
            <div class="form-group">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Exemplo: Previsão para pagamento 04/07/2022 conforme contrato"></textarea>
            </div>
        </div>
    </div>
    {{-- <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputCity">Descrição do serviço</label>
            <div class="form-group">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Exemplo: Referente ao serviço de manutenção corretiva..."></textarea>
            </div>
        </div>
    </div> --}}

    <div class="form-group">
        <label for="exampleFormControlFile1">Escolha o arquivo</label>
        <input type="file" class="form-control-file" id="exampleFormControlFile1">
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
</form>
</div>

@endsection