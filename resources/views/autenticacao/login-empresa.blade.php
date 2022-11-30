<?php
session_start();
if (!isset($_SESSION["sessao_empresa"])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Página de login</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <!------ Include the above in your HEAD tag ---------->  
    <link rel="stylesheet" href="{{asset('css/login-empresa.css')}}">
</head>
<body>

    <div class="wrapper fadeInDown">
        <div id="formContent">     
        <!-- Tabs Titles -->      <!-- Icon -->     
            <div class="fadeIn first">
                <span>Faça seu Login</span>
            </div>     
            <!-- Login Form -->     
            <form action="{{route('login.store')}}" method="POST">
                @csrf
                <input type="text" id="input-cnpj" class="fadeIn second" name="cnpj" placeholder="cnpj" maxlength="18" class="form-control rounded-form" value="<?php if (isset($_SESSION['campo_cnpj'])) { echo $_SESSION['campo_cnpj']; } ?>">       
                <input type="password" id="password" class="fadeIn third" name="senha" placeholder="senha" value="<?php if (isset($_SESSION['campo_senha'])) { echo $_SESSION['campo_senha']; } ?>">
                
                @if (session("error"))
                    <div class="alert alert-danger" style="text-align: center">
                        {{session("error")}}
                    </div>
                @endif

                <input type="submit" class="fadeIn fourth" value="Conecte-se">  
            </form>
            <!-- Remind Passowrd -->     
            <div id="formFooter">       
                <a class="underlineHover" href="#">Esqueceu a senha?</a>
            </div>
        </div>
    </div>
    <script src="{{asset('js/login-empresa.js')}}"></script>
</body>
</html>

{{-- excluir as sessões dos inputs --}}
<?php
if (isset($_SESSION['campo_cnpj'])) { unset($_SESSION['campo_cnpj']); }

if (isset($_SESSION['campo_senha'])) { unset($_SESSION['campo_senha']); }
?>

<?php
}else {
?>
    <script>window.location.href = window.location.protocol + "//" + window.location.host + "/nota-fiscal";</script>
<?php
}
?>