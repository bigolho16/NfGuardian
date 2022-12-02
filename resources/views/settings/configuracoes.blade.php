

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Configurações</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 

    <script src="{{asset('js/configuracoes.js')}}"></script>

    <link rel="stylesheet" href="css/configuracoes.css">
</head>
<body <?php if (session('success') || session('error')) { echo 'onload="mostramodal ()"'; } ?>>
    <ul class="nav">
        <li class="nav-item">
            <a href="{{route('notas-fiscais')}}"><span class="nav-link active" style="color:white"><i class="fa fa-university" aria-hidden="true"></i>
                 Pagina inicial</span></a>
        </li>
    </ul>
    
    {{-- Edicao dos dados da empresa --}}
    
    <div class="div-pai-config">
        <h3>Configurações</h3>

        <div class="div-elems">
        <h5>Informações da empresa</h5>

        <form action="{{route('configuracoes.update', ['configuraco' => $_SESSION['sessao_empresa']->codigo])}}" method="POST" class="needs-validation" novalidate>
            {{-- Para dar certo o meétodo update do controller --}}
            {{ method_field('PATCH') }}
            @csrf

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom01">Nome:</label>
                    <input type="text" class="form-control" id="validationCustom01" placeholder="nome da sua empresa" name="nome" value="<?php if (isset($_SESSION['campo_nome'])) { echo $_SESSION['campo_nome']; }else { echo $_SESSION['sessao_empresa']->nome; } ?>" required>
                    <div class="invalid-feedback">
                        O campo nome da empresa não pode ficar vazio!
                    </div>
                    
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom02">CNPJ:</label>
                    <input type="text" class="form-control" id="input-cnpj" placeholder="exemplo: 36.567.261/0001-35" name="cnpj" value="<?php if (isset($_SESSION['campo_cnpj'])) { echo $_SESSION['campo_cnpj']; }else {  echo $_SESSION['sessao_empresa']->cnpj; } ?>" required>
                    <div class="invalid-feedback">
                        Por favor, informe o CNPJ!
                    </div>
                </div>
            </div>

            <button class="btn btn-primary" type="submit">Enviar</button>
        </form>

        <?php //print_r($_SESSION['sessao_empresa']); ?>

        </div>

        <div class="div-elems">
            <h5>Alterar a senha de acesso</h5>
    
            <form action="{{route('configuracoes.update', ['configuraco' => $_SESSION['sessao_empresa']->codigo])}}" method="POST" class="needs-validation" novalidate>
                {{ method_field('PATCH') }}
                @csrf
                
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="validationCustomUsername">Senha antiga:</label>
                        <input type="text" name="senha_antiga" class="form-control" id="validationCustomUsername" placeholder="sua senha antiga do sistema" aria-describedby="inputGroupPrepend" required>
                        <div class="invalid-feedback">
                            Por favor, confirme sua senha anterior para poder alterar a senha!
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationCustomUsername">Nova senha:</label>
                        <input type="text" name="nova_senha" class="form-control" id="validationCustomUsername" placeholder="sua nova senha do sistema" aria-describedby="inputGroupPrepend" required>
                        <div class="invalid-feedback">
                            Por favor, digite uma nova senha!
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Alterar senha</button>
            </form>
        </div>

        {{-- Edicao dos dados do funcionário --}}
        <div class="div-elems">
        <h5>Informações do funcionário da empresa:</h5>

        <form action="{{route('configuracoes.store')}}" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom01">Nome:</label>
                <input type="text" name="nome" class="form-control" id="validationCustom01" placeholder="nome do funcionário da empresa" required>
                <div class="invalid-feedback">
                    Por favor, digite o nome do funcionário da empresa.
                </div>
                
            </div>
            <div class="col-md-4 mb-3">
                <label for="validationCustom02">Cargo:</label>
                <input type="text" name="cargo" class="form-control" id="validationCustom02" placeholder="exemplo: Assistente Administrativo, Estagiário..." required>
                <div class="invalid-feedback">
                    Por favor, digite o cargo do funcionário.
                </div>
            </div>
            </div>

            <button class="btn btn-primary" type="submit">Adicionar funcionário</button>
        </form>
        </div>

        <div class="div-elems needs-validation">
        <h5>Funcionários:</h5>

        <table class="table table-funcionarios">
            <thead>
              <tr>
                <th scope="col">Código</th>
                <th scope="col">Nome</th>
                <th scope="col">Cargo</th>
                <th scope="col">Alterar</th>
                <th scope="col">Excluir</th>
              </tr>
            </thead>

            <tbody>
                @foreach ($todosfuncionarios as $funcionario)
                    

                        <tr>
                            <td>{{$funcionario->codigo}}</td>
                            <td><input type="text" name="nome"  value="{{$funcionario->nome}}"></td>
                            <td><input type="text" name="cargo" value="{{$funcionario->cargo}}"></td>
                            
                            <td><a href="{{route('configuracoes.alterar-funcionario')}}?codigo={{$funcionario->codigo}}&nome={{$funcionario->nome}}&cargo={{$funcionario->cargo}}"><i title="clique para editar" class="fa fa-pencil-square-o" aria-hidden="true" style="cursor: pointer;"></i></a></td>
                            
                            <td><i title="clique para excluir" class="fa fa-trash tag-i-destroy" id="tag-i-destroy-{{$funcionario->codigo}}" aria-hidden="true" style="cursor: pointer;"></i></td>
                        </tr>
                    
                @endforeach
              {{-- <tr>
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
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
              </tr> --}}
            </tbody>

          </table>
        </div>
    </div>

    {{-- Modal mensagem --}}
    <div class="modal fade" id="modaldemensagem" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mensagem:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
            </div>
            </div>
        </div>
    </div>

    {{-- Modal excluir funcionário --}}
    <div class="modal fade" id="modaldeexcluirfuncionario" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="{{route('configuracoes.destroy', ['configuraco'=>0])}}" method="POST" id="form-delete-funcionario">
                {!! method_field('delete') !!}
                @csrf
                {{-- <input type="hidden" id="inp_cod_func" name="codigo_funcionario" value=""> --}}

                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mensagem:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja excluir este funcionário?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                    <button type="submit" class="btn btn-secondary">Sim</button>
                </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        // Exemplo de JavaScript inicial para desativar envios de formulário, se houver campos inválidos.
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Pega todos os formulários que nós queremos aplicar estilos de validação Bootstrap personalizados.
            var forms = document.getElementsByClassName('needs-validation');
            // Faz um loop neles e evita o envio
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
    </script>
</body>
</html>

{{-- excluir as sessões dos inputs --}}
<?php
if (isset($_SESSION['campo_nome'])) { unset($_SESSION['campo_nome']); }

if (isset($_SESSION['campo_cnpj'])) { unset($_SESSION['campo_cnpj']); }
?>