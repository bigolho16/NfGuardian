@section("modal-largo")
<!-- Botão de exemplo -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
</button> --}}

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            
            <h5 class="modal-title" id="exampleModalLabel">

            </h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            {{-- Contéudo do modal aqui --}}
<?php
            //Criar Script PHP que faça alterar o conteúdo deste modal toda vez que a página é alterada
            $request_uri = $_SERVER["REQUEST_URI"];
            if ($request_uri == "/estoque/produto") {
?>
                @include('estoque.produto')
                @yield("formulario-para-insert")
<?php
            }
?>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary">Salvar Alterações</button>
        </div>
        </div>
    </div>
</div>

@endsection