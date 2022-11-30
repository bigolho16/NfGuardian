$(document).ready(function () {
    // [ VARIÁVEIS DO MENU-CONTEXTO, RETIRADO DA INTERNET ]
    //Events for desktop and touch
    let events = ["contextmenu", "touchstart"];
    //initial declaration
    var timeout;
    //for double tap
    var lastTap = 0;
    // [ FIM-SE, VARIÁVEIS DO MENU-CONTEXTO, RETIRADO DA INTERNET ]

    // Para carregar a proteção csrf, pois ela não vem inclusa altomaticamente e precisa configurar manualmente
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var $xhr = new XMLHttpRequest();

    var protocotoHost = window.location.protocol + "//" + window.location.host; // http://10.0.0.160:8000/
    var rotadaurl = window.location.pathname;

    if (rotadaurl == "/nota-fiscal" || rotadaurl == "/nota-fiscal/controle-de-nfs") {
        $(".btn-top-add").click(function () {
            //Criando os elementos tr e tds
            var corpodotbody = $("<tr><td id='nota_fiscal_codigo'></td><td id='data_emissao'></td><td id='prestador_de_servico'></td><td id='tomada_de_servico'></td><td id='descricao_de_servico'></td><td id='valor_do_servico'></td><td id='iss'></td><td id='ir'></td><td id='pis'></td><td id='cofins'></td><td id='csll'></td><td id='inss'></td><td id='outras_retencoes'></td><td id='total_liquido'></td><td id='situacao'></td></tr>");

            //Adicionar esses elementos ao tbody
            $(".tabela-controle-nfs tbody").append(corpodotbody);

            // $xhr.onreadystatechange = function () {
            //     if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
            //         console.log(this.responseText)
            //     }
            // }
            // $xhr.open("GET", "http://10.0.0.160:8000/estoque/produto/modal-largo");
            // $xhr.send();
        });

        // Para alterar ou até criar estas opções, consulte: https://getbootstrap.com/docs/4.0/components/modal/#options
        var btnedit = $("#botao-menu-adicionar");
        btnedit.click(function () {
            $("#exampleModal").modal({
                show: false,
            });
        });

        // $(document).on("dblclick", ".tabela-controle-nfs tbody tr td", function () {
        //     //Mexer no css depois para resolver a questão do input que ta alterando a tabela
            
        //     var inputedicaotabela = $("<input type='text'>")
        //     .css({
        //         "display":"block"
        //     }).attr({
        //         "class":"inputedicaotabela"
        //     });

        //     $(this).append(inputedicaotabela);

        //     $(inputedicaotabela).focus();

        //     $(inputedicaotabela).blur( () => {
        //         //Saber qual linha ele vai alterar
        //         coluna = $(inputedicaotabela).parent().attr("id");

        //         //Ajax para salvar/editar os dados na tabela
        //         savetabledata(coluna, $(inputedicaotabela).val());
        //         $(inputedicaotabela).remove();
        //     });
        // });
        $(document).on("dblclick", ".tabela-controle-nfs tbody tr td", function () { monitoringEditInputTable (this) });

    } else if (rotadaurl == "/nota-fiscal/controle-de-imposto") {
        //Eventos de duplo-click p/ criação do input dentro de th|td
        $(document).on("dblclick", ".tabela-controle-de-imposto tbody tr td", function () { monitoringEditInputTable (this) });
        $(document).on("dblclick", ".tabela-controle-de-imposto thead tr th", function () { monitoringEditInputTable (this) });

        //Evento de clique-botao-direito p/ criação menu-contexto
        ths = document.querySelectorAll(".tabela-controle-de-imposto thead tr th");
        tds = document.querySelectorAll(".tabela-controle-de-imposto tbody tr td");

        //same function for both events
        lastThClicked = "";
        events.forEach((eventType) => {
            ths.forEach(th => {
                th.addEventListener(
                    eventType,
                    (e) => {
                        chamaMenuContexto (e);

                        lastThClicked = th;

                        if (lastTdClicked != "") {
                            lastTdClicked = "";
                        }

                        // deleteTableColumn (th);
                    },
                    { passive: false }
                );
            });
        });
        //same function for both events
        lastTdClicked = "";
        events.forEach((eventType) => {
            tds.forEach(td => {
                td.addEventListener(
                    eventType,
                    (e) => {
                        chamaMenuContexto (e);

                        lastTdClicked = td;

                        if (lastThClicked != "") {
                            lastThClicked = "";
                        }

                        // deleteTableColumn (td);
                    },
                    { passive: false }
                );
            });
        });
        
        $(".item-botao-excluir-menu-contexto").click(function () {
            if (lastTdClicked != "") {
                confirmarAcaoAntesDoAjaxDelete(lastTdClicked);
            } else if (lastThClicked != "") {
                confirmarAcaoAntesDoAjaxDelete(lastThClicked);
            }
        });

    }
    
    //Para facilitar a criação dos inputs-edits que ficam dentro do th|td
    function monitoringEditInputTable (elemClicado) {
        //Pegar texto antigo do th|td
        textoAntigo = elemClicado.innerText;
        //Criação do input p/ edição
        var inputedicaotabela = $("<input type='text'>")
        .css({
            "display":"block"
        }).attr({
            "class":"inputedicaotabela"
        }).val(elemClicado.innerText);
        //Deletar o texto do td|th
        elemClicado.innerText = "";
        //Adiciona input ao td
        $(elemClicado).append(inputedicaotabela);
        //Dar foco ao input
        $(inputedicaotabela).focus();


        //Caso eu tire o foco do input
        $(inputedicaotabela).blur( () => {
            if (inputedicaotabela.val() != textoAntigo) {
                //head-codigo-x estou querendo alterar imposto, e se for body-codigo-x está querendo alterar taxa
                //Pegar esses dados que estão acima para envio
                dado = inputedicaotabela.val();


                //Vai ser ou o head da tabela que vou esta alterando ou o body!!
                separarHeadOuBodyTabelasComColunasVerticaisOuHorizontais (inputedicaotabela, dado);
                
                // console.log("há ajax")

            }
            
            //Retorna o texto do input para o th|td
            elemClicado.innerText = inputedicaotabela.val();

            $(inputedicaotabela).remove();
        });
    }

    //Colunas verticais=normal (tente comparar com a estrutura de armazenamento no mysql)
    function separarHeadOuBodyTabelasComColunasVerticaisOuHorizontais (inputedicaotabela, dado) {

        if ($('.cabecalho-alteravel').length && $('.corpo-alteravel').length) {
            headORbody = inputedicaotabela.parent().attr("class");
            head = 0; body = 0;
            if (headORbody.search("head-codigo-") != -1) {
                head = inputedicaotabela.parent().attr("class");
                spl = head.split('head-codigo-');
                
                updateTableData (spl[spl.length-1], '', dado);
            }
            if (headORbody.search("body-codigo-") != -1) {
                body = inputedicaotabela.parent().attr("class");
                spl = body.split('body-codigo-');

                updateTableData ('', spl[spl.length-1], dado);
            }
            // console.log('esta alterando head ou body')
        }

        //Divisão mais geral do formato da class que o td possui (Do lado esquedo é a linha, do lado direito é a coluna 'no que tange na montagem do json p/ envio')
        if (!$('.cabecalho-alteravel').length && $('.corpo-alteravel').length) {
            lineOrColumn = inputedicaotabela.parent().attr("class");
            linha = ""; coluna = "";

            //Separando agr lado esquerdo(linha) e direito(coluna)
            lineOrColumn = lineOrColumn.split(' ');
            linha = lineOrColumn[0];
            coluna = lineOrColumn[1];
            
            //Para pegar somente os números
            numlinha = linha.replace(/[^0-9]/g, '');

            //Para pegar somente os números
            numcoluna = coluna.replace(/[^0-9]/g, '');
            //Caso ele não encontre os números no algoritmo acima pegue as palavras mesmo
            if (!numcoluna) {
                numcoluna = coluna;
            }
            linha = numlinha;
            coluna = numcoluna;

            updateTableData(linha, coluna, dado)
            // console.log(linha + ' e ' + coluna)
        }

    }

    //Por exemplo , vai excluir um imposto que está em coluna na tabela!
    function deleteTableColumn (id) {
        $.ajax({
            type: "DELETE",
            url: protocotoHost + rotadaurl + "/" + id,
            success: function (response) {
                rjp = JSON.parse(response);

                if (rjp == "success") {
                    window.location.reload();
                }
            }
        });
    }

    function confirmarAcaoAntesDoAjaxDelete (elementoSalvo) {
        //Separar o id que tem na class padrão das tabelas
        elemClass = $(elementoSalvo).attr("class");
        //Pega apenas os números da class (head-codigo-x|body-codigo-y)
        id = elemClass.replace(/[^0-9]/g, '');

        condition = confirm("Deseja realmente excluir esta coluna?");

        if (condition == true) {
            deleteTableColumn (id);
        }
    }

    function savetabledata (head, body, dado) {
        $.ajax({
            type: "POST",
            url: protocotoHost + rotadaurl,
            data: {
                head: head,
                body: body,
                dado: dado,
            },
            success: function (response) {
                console.log(response)
            }
        });
    }

    function updateTableData (head, body, dado) {
        $.ajax({
            type: "PUT",
            url: protocotoHost + rotadaurl + "/" + head+body,
            data: {
                head: head,
                body: body,
                dado: dado,
            },
            success: function (response) {
                rjp = JSON.parse(response);

                //Normalmente tem: rjp.error / rjp.linhaalterada
                if (rjp.error == 0) {
                    // window.location.reload();
                    linhaalterada = JSON.parse(rjp.linhaalterada);
                    ch_estrangeira = JSON.parse(rjp.valores_impostos);

                    atualizaLinhaDaTabela (linhaalterada, ch_estrangeira);
                }
            }
        });
    }

    //Feita pensando na página /controle-de-nf
    function atualizaLinhaDaTabela (linhaalterada, ch_estrangeira) {
        //Extrair chaves (colunas no db)
        keylinhaalterada = Object.keys(linhaalterada);
        //Extrair somente os valores e joga no array
        vallinhaalterada = Object.values(linhaalterada);

        //Pega todos elementos filhos da linha que são tds
        linhatabela = $(".line-" + linhaalterada.codigo);
        filhoslinhatabela = linhatabela.find("td");

        scfl = "";
        for (var x=0; x < filhoslinhatabela.length; x++) {
            classfilholinha = $(filhoslinhatabela[x]).attr("class");
            scfl = classfilholinha.split(" ")[1];

            //Incluir os dados da tabela controle_de_nf normalmente
            for (var y=0; y < keylinhaalterada.length; y++) {
                if (keylinhaalterada[y] == scfl) {
                    $(filhoslinhatabela[x]).text(vallinhaalterada[y]);
                    break;
                }
            }
            
            //Incluir os dados dos impostos
            for (var z=0; z < ch_estrangeira.length; z++) {
                if ("cod-imposto-"+ch_estrangeira[z].codigo_valores_impostos_codigo_controle_de_imposto == scfl) {
                    $(filhoslinhatabela[x]).text(ch_estrangeira[z].valor);
                }
            }
        }
    }

    function converterObjetoEmArray (objeto) {
        var arr = objeto.map(function (obj) {
            return Object.keys(obj).map(function(key){
                return obj[key];
            })
        });

        return arr;
    }


// [ JAVASCRIPT DO MENU-CONTEXTO, RETIRADO DA INTERNET ]
//refer menu div
let contextMenu = document.getElementById("context-menu");

function chamaMenuContexto (e) {
    e.preventDefault();
      //x and y position of mouse or touch
      let mouseX = e.clientX || e.touches[0].clientX;
      let mouseY = e.clientY || e.touches[0].clientY;
      //height and width of menu
      let menuHeight = contextMenu.getBoundingClientRect().height;
      let menuWidth = contextMenu.getBoundingClientRect().width;
      //width and height of screen
      let width = window.innerWidth;
      let height = window.innerHeight;
      //If user clicks/touches near right corner
      if (width - mouseX <= 200) {
        contextMenu.style.borderRadius = "5px 0 5px 5px";
        contextMenu.style.left = width - menuWidth + "px";
        contextMenu.style.top = mouseY + "px";
        //right bottom
        if (height - mouseY <= 200) {
          contextMenu.style.top = mouseY - menuHeight + "px";
          contextMenu.style.borderRadius = "5px 5px 0 5px";
        }
      }
      //left
      else {
        contextMenu.style.borderRadius = "0 5px 5px 5px";
        contextMenu.style.left = mouseX + "px";
        contextMenu.style.top = mouseY + "px";
        //left bottom
        if (height - mouseY <= 200) {
          contextMenu.style.top = mouseY - menuHeight + "px";
          contextMenu.style.borderRadius = "5px 5px 5px 0";
        }
      }
      //display the menu
      contextMenu.style.visibility = "visible";
    
}

//for double tap(works on touch devices)
document.addEventListener("touchend", function (e) {
  //current time
  var currentTime = new Date().getTime();
  //gap between two gaps
  var tapLength = currentTime - lastTap;
  //clear previous timeouts(if any)
  clearTimeout(timeout);
  //if user taps twice in 500ms
  if (tapLength < 500 && tapLength > 0) {
    //hide menu
    contextMenu.style.visibility = "hidden";
    e.preventDefault();
  } else {
    //timeout if user doesn't tap after 500ms
    timeout = setTimeout(function () {
      clearTimeout(timeout);
    }, 500);
  }
  //lastTap set to current time
  lastTap = currentTime;
});

//click outside the menu to close it (for click devices)
document.addEventListener("click", function (e) {
  if (!contextMenu.contains(e.target)) {
    contextMenu.style.visibility = "hidden";
  }
});
// [ FIM-SE, JAVASCRIPT DO MENU-CONTEXTO, RETIRADO DA INTERNET ]
});