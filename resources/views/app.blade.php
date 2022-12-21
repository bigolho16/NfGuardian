@include("modals.menus")
@include("modals.modal-largo")

<?php
  // Script para alterar para página especifica de acordo com a rota
  $categoria   = [
    "/dashboard",
    "/estoque"
  ];
  $request_uri  = $_SERVER["REQUEST_URI"];
?>

<!DOCTYPE html>
<html>
<head>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

{{-- Adicionando meta p/ Jquery --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

{{-- Script do Jquery: só deu ctrl+c e ctrl+v em:https://code.jquery.com/jquery-3.6.1.min.js --}}
<script src="{{asset('js/jquery-3.6.1.min.js')}}"></script>

{{-- Script geral (Helper) --}}
<script type="text/javascript" src="{{asset('js/functions.js')}}"></script>

{{-- Interno --}}
@stack('estilo-de-menus')

{{-- Externo --}}
{{-- O estilo Bootstrap, o script tá no final da página --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

{{-- Línk dos ícones do site fontes.google.com/icons --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>
<body class="w3-light-grey w3-content" style="max-width:1600px">

@yield('nav-lateral')

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px">

  @yield('menu-topo')

{{-- páginas incluídas aqui... --}}
<?php
  if ($request_uri == "/") {
?>
    @include('welcome')
    @stack('estilo-do-welcome')
    @yield('corpo-do-welcome')
<?php
  }
?>
<?php
  if ($request_uri == "/dashboard") {
?>
    @include('dashboard.dashboard')
<?php
  }
  if ($request_uri == "/estoque") {
?>
    @include('estoque.estoque')
<?php
  }
?>
<?php
  if ($request_uri == "/estoque/produto") {
?>
    @stack('estilo-produto')
    @include('estoque.produto')
    @yield("tabela-principal-de-produto")
<?php
  }
?>
<?php
  if ($request_uri == "/nota-fiscal") {
?>
    @include('nota-fiscal.notas-fiscais')
    @stack("estilo-notas-fiscais")
    @stack('script-notas-fiscais')
    @yield('formulario-de-insercao-notas')
<?php
  }
?>
<?php
  if ($request_uri == "/nota-fiscal/controle-de-nfs") {
?>
    @include('nota-fiscal.controle-de-nfs')
    @stack("estilo-controle-de-nfs")
    @stack('script-controle-de-nfs')
    @yield('campo-de-pesquisa-para-tabela')
    @yield('tabela-controle-de-nfs')
<?php
  }
?>

<?php
  if ($request_uri == "/nota-fiscal/controle-de-imposto") {
?>
    @include('nota-fiscal.controle-de-imposto')
    @stack('estilo-controle-de-imposto')
    @yield("form-controle-de-imposto")
    @yield("tabela-controle-de-imposto")
<?php
  }
?>

{{-- Menu de Contexto aqui --}}
@include('menu-de-contexto.menu-de-contexto')
@stack("estilo-menu-de-contexto")
@yield("section-menu-de-contexto")

{{-- Modals aqui --}}
@yield("modal-largo")

{{-- rodapé aqui... --}}

</div>

<script>
// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
</script>

{{-- Os scripts do Bootstrap --}}
{{-- Tive que comentar a versão Slim deste Jquery pois estava conflitando com o que ja importei no head --}}
{{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>