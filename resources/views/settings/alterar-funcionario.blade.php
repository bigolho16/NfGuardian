<?php
session_start();

if (isset($_SESSION['sessao_empresa'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alterar funcionário</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{asset('css/alterar-funcionario.css')}}">
    <script>
        function mostramodal () {
            $('#modaldemensagem').modal('show');
        }
    </script>
</head>
<body <?php if (session('success') || session('error')) { echo 'onload="mostramodal ()"'; } ?>>
    <ul class="nav">
        <li class="nav-item">
            <a href="{{route('configuracoes.index')}}"><span class="nav-link active" style="color:white"><i class="fa fa-reply" aria-hidden="true"></i>
                 Voltar para configurações</span></a>
        </li>
    </ul>

    <div class="div-pai-config">
        <div class="div-elems">
            <h5>Alterar funcionário:</h5>

            <form action="{{route('configuracoes.update', ['configuraco' => $_GET['codigo']])}}" method="POST" class="needs-validation" novalidate>
                {{ method_field('PATCH') }}
                @csrf

                <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom01">Nome:</label>
                    <input type="text" name="nome" value="{{$_GET['nome']}}" class="form-control" id="validationCustom01" placeholder="nome do funcionário da empresa" required>
                    <div class="invalid-feedback">
                        Por favor, digite o nome do funcionário da empresa.
                    </div>
                    
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom02">Cargo:</label>
                    <input type="text" name="cargo" value="{{$_GET['cargo']}}" class="form-control" id="validationCustom02" placeholder="exemplo: Assistente Administrativo, Estagiário..." required>
                    <div class="invalid-feedback">
                        Por favor, digite o cargo do funcionário.
                    </div>
                </div>
                </div>

                <button class="btn btn-primary" type="submit">Alterar</button>
            </form>
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

<?php
}else {
?>
    <script>window.location.href = window.location.protocol + "//" + window.location.host + "/login";</script>
<?php
}
?>