function moeda(a, e, r, t) {
    let n = ""
      , h = j = 0
      , u = tamanho2 = 0
      , l = ajd2 = ""
      , o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
        return !0;
    if (n = String.fromCharCode(o),
    -1 == "0123456789".indexOf(n))
        return !1;
    for (u = a.value.length,
    h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
        ;
    for (l = ""; h < u; h++)
        -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
    0 == (u = l.length) && (a.value = ""),
    1 == u && (a.value = "0" + r + "0" + l),
    2 == u && (a.value = "0" + r + l),
    u > 2) {
        for (ajd2 = "",
        j = 0,
        h = u - 3; h >= 0; h--)
            3 == j && (ajd2 += e,
            j = 0),
            ajd2 += l.charAt(h),
            j++;
        for (a.value = "",
        tamanho2 = ajd2.length,
        h = tamanho2 - 1; h >= 0; h--)
            a.value += ajd2.charAt(h);
        a.value += r + l.substr(u - 2, u)
    }
    return !1
}

function fileValidation () {
    var fileInput = 
        document.getElementsByClassName('form-control-file')[0];
        
    var filePath = fileInput.value;
    
    // Allowing file type
    var allowedExtensions = 
            /(\.pdf|\.xml|\.doc|\.docx|\.xls|\.xlsx|\.ppt|\.pptx|\.txt|\.csv|\.jpg|\.jpeg|\.png)$/i;
        
    if (!allowedExtensions.exec(filePath)) {
        alert('Tipo de arquivo inválido!');
        fileInput.value = '';
        return false;
    }

    // Lembrando que size retorna em formato byte, logo 15728640 Bytes == 15 Mb
    if (fileInput.files[0].size > 15728640) {
        alert('Tamanho de arquivo inválido');
        fileInput.value = '';
        return false;
    }
}
function confirmEmptyFile () {
    var fileInput = 
        document.getElementsByClassName('form-control-file')[0];

    if (fileInput.value == "") {
        let msg = "Deseja enviar mesmo sem ter escolhido um arquivo?";

        if (confirm(msg) == false) {
            return false;
        }
    }
}