@push('estilo-notas-fiscais')
    <link rel="stylesheet" href="{{asset('css/notas-fiscais.css')}}">
@endpush

@push('script-notas-fiscais')
<script src="{{asset('js/notas-fiscais.js')}}"></script>
@endpush

@section('formulario-de-insercao-notas')

{{-- Exibição das mensagens de sucesso ou erros --}}
@if(session("success"))
<div class="alert alert-success">
    {{ session("success") }}
</div>
@endif
@if (session("error"))
        <div class="alert alert-danger" style="text-align: center">
            {{session("error")}}
        </div>
@endif

<h5 style="padding: 10px;">Inserção das notas fiscais:</h5>

<div class="div-pai-formulario-insercao-notas">
<form method="POST" action="{{route('nota-fiscal.store')}}" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputCodNota">Código da nota</label>
            <input type="text" name="codigo_da_nota" class="form-control" id="inputCodNota" placeholder="Um identificador para nota fiscal" required oninvalid="this.setCustomValidity('Dê um identificador único para sua nota!')" oninput="setCustomValidity('')" value="<?php if(isset($_SESSION['codigo_da_nota'])){echo $_SESSION['codigo_da_nota'];} ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="inputPassword4">Data de emissão</label>
            <input type="date" name="data_de_emissao" class="form-control" id="inputPassword4" placeholder="Data de emissão da nota fiscal" value="<?php if(isset($_SESSION['data_de_emissao'])){echo $_SESSION['data_de_emissao'];} ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="inputAddress">Prestador do serviço</label>
        <input type="text" name="prestador_de_servico" class="form-control" id="inputAddress" placeholder="Empresa prestadora do serviço" value="<?php if(isset($_SESSION['prestador_de_servico'])){echo $_SESSION['prestador_de_servico'];} ?>">
    </div>
    <div class="form-group">
        <label for="inputAddress2">Tomada de serviço</label>
        <input type="text" name="tomada_de_servico" class="form-control" id="inputAddress2" placeholder="Para qual empresa foi prestado o serviço" value="<?php if(isset($_SESSION['tomada_de_servico'])){echo $_SESSION['tomada_de_servico'];} ?>">
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="inputCity">Descrição do serviço</label>
            <div class="form-group">
                <textarea name="descricao_do_servico" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Exemplo: Referente ao serviço de manutenção corretiva..."><?php if(isset($_SESSION['descricao_do_servico'])){echo $_SESSION['descricao_do_servico'];} ?></textarea>
            </div>
        </div>

        <div class="form-group col-md-3">
            <label for="inputAddress">Valor do serviço (R$)</label>
            <input type="text" name="valor_do_servico" class="form-control" id="inputAddress" placeholder="Valor cobrado no serviço" onKeyPress="return(moeda(this,'.',',',event))" value="<?php if(isset($_SESSION['valor_do_servico'])){echo $_SESSION['valor_do_servico'];} ?>">
        </div>
        <div class="form-group col-md-3">
            <label for="inputState">Situação</label>
            <select id="inputState" class="form-control" name="situacao">

                <?php
                    if (isset($_SESSION["situacao"])) {
                        if ($_SESSION["situacao"] == "true") {
                ?>          <option>Escolher...</option>
                            <option value="true" selected>Nota paga</option>
                            <option value="false">Nota não paga (andamento)</option>
                <?php
                        }else if ($_SESSION["situacao"] == "false") {
                ?>
                            <option>Escolher...</option>
                            <option value="true">Nota paga</option>
                            <option value="false" selected>Nota não paga (andamento)</option>
                <?php
                        }else {
                ?>
                            <option selected>Escolher...</option>
                            <option value="true">Nota paga</option>
                            <option value="false">Nota não paga (andamento)</option>
                <?php
                        }
                    }
                    if (!isset($_SESSION["situacao"])) {
                ?>
                        <option selected>Escolher...</option>
                        <option value="true">Nota paga</option>
                        <option value="false">Nota não paga (andamento)</option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="inputState">Descrição da situação</label>
            <div class="form-group">
                <textarea name="descricao_da_situacao" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Exemplo: Previsão para pagamento 04/07/2022 conforme contrato"><?php if(isset($_SESSION['descricao_da_situacao'])){echo $_SESSION['descricao_da_situacao'];} ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="inputState">Modificado por:</label>
        <select id="inputState" class="form-control" name="modificado_por">
            <?php
                if (!empty($_SESSION["modificado_por"])) {
            ?>
                        <option>Escolher...</option>
                        @foreach ($funcionarios as $funcionario)
                            @if ($funcionario->codigoEmpresa == $_SESSION['sessao_empresa']->codigo)
                                @if ($_SESSION['modificado_por'] == $funcionario->codigo)
                                    <option value="{{$funcionario->codigo}}" selected>Nome: {{$funcionario->nome}} - Cargo: {{$funcionario->cargo}}</option>
                                @else
                                    <option value="{{$funcionario->codigo}}">Nome: {{$funcionario->nome}} - Cargo: {{$funcionario->cargo}}</option>
                                @endif
                            @endif
                        @endforeach
            <?php
                }
                if (empty($_SESSION['modificado_por'])) {
            ?>
                    <option selected>Escolher...</option>
                    @foreach ($funcionarios as $funcionario)
                        @if ($funcionario->codigoEmpresa == $_SESSION['sessao_empresa']->codigo)
                            <option value="{{$funcionario->codigo}}">Nome: {{$funcionario->nome}} - Cargo: {{$funcionario->cargo}}</option>
                        @endif
                    @endforeach
            <?php
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="exampleFormControlFile1">Escolha o arquivo (Limite: 15 MB)</label>
        <input type="file" name="arquivo_nota" class="form-control-file" id="exampleFormControlFile1" onchange="return fileValidation ()">
    </div>

    <button type="submit" class="btn btn-primary" onclick="return confirmEmptyFile ()">Enviar</button>
</form>

<?php
    //Apagar as variáveis de sessão dos campos
    unset($_SESSION["codigo_da_nota"]);
    unset($_SESSION["data_de_emissao"]);
    unset($_SESSION["prestador_de_servico"]);
    unset($_SESSION["tomada_de_servico"]);
    unset($_SESSION["descricao_do_servico"]);
    unset($_SESSION["valor_do_servico"]);
    unset($_SESSION["situacao"]);
    unset($_SESSION["descricao_da_situacao"]);
    unset($_SESSION["modificado_por"]);
?>
</div>
@endsection