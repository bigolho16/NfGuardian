$(document).ready(function () {
    var protocolhost = window.location.protocol + "//" + window.location.host;
    var rotadaurl = window.location.pathname;

    //Validação do campo cnpj
    document.getElementById('input-cnpj').addEventListener('input', function (e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})/);
        e.target.value = !x[2] ? x[1] : x[1] + '.' + x[2] + '.' + x[3] + '/' + x[4] + (x[5] ? '-' + x[5] : '');
    });

    // javascript da ação excluir funcionário
    $(".tag-i-destroy").click(function () {
        $iddatagi = $(this).attr("id");

        $numidtagi = $iddatagi.replace(/[^0-9]/g, '');

        document.getElementById("form-delete-funcionario").action = protocolhost + rotadaurl + '/' + $numidtagi;

        //Mostra modal
        $('#modaldeexcluirfuncionario').modal('show')
    });

});

function mostramodal () {
    $('#modaldemensagem').modal('show');
}