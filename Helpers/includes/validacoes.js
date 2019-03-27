$(function () {

    //VARIÁVEIS GLOBAIS
    var dados = constantes();

    var home = dados['HOME'];
    var inativo = dados['INATIVO'];
    var ambiente = dados['AMBIENTE'];
    var urlValida = home + 'library/Helpers/Valida.Controller.php';

    // DESLOGA USUÁRIO INATIVO DO MODULO DO SISTEMA
    if (ambiente == 'ADMIN') {
        setTimeout(function () {
            location.reload();
        }, (1001 * inativo * 60));
    }

    //function to initiate Select2
    $(".search-select").select2({
        allowClear: false
    });

    function validaData(data, id) {
        if (data != "") {
            var erro = "";
            var bissexto = 0;
            var tam = data.length;
            if (tam == 10) {
                var dia = data.substr(0, 2);
                var mes = data.substr(3, 2);
                var ano = data.substr(6, 4);
                if ((ano > 1900) || (ano < 2100)) {
                    switch (mes) {
                        case '01':
                        case '03':
                        case '05':
                        case '07':
                        case '08':
                        case '10':
                        case '12':
                            if (dia <= 31) {
                                erro = true;
                            }
                            break;
                        case '04':
                        case '06':
                        case '09':
                        case '11':
                            if (dia <= 30) {
                                erro = true;
                            }
                            break;
                        case '02':
                            if ((ano % 4 == 0) || (ano % 100 == 0) || (ano % 400 == 0)) {
                                bissexto = 1;
                            }
                            if ((bissexto == 1) && (dia <= 29)) {
                                erro = true;
                            }
                            if ((bissexto != 1) && (dia <= 28)) {
                                erro = true;
                            }
                            break
                    }
                }
            }
            if (erro != true) {
                validaErro(id, "DATA Informada Inválida!");
            } else {
                validaOK(id, "Data válida!");
            }
        } else {
            tiraValidacao(id);
        }
    }

    function validaCPF(cpf, id) {
        if (cpf != "") {
            $.get(urlValida, {valida: 'valcpf', cpf: cpf}, function (retorno) {
                if (retorno == 2) {
                    validaErro(id, "CPF inválido! favor verificar.");
                } else {
                    validaOK(id, "CPF válido!");
                }
            });
        } else {
            tiraValidacao(id);
        }
    }

    function validaEmail(email, id) {
        if (email != "") {
            $.get(urlValida, {valida: 'valemail', email: email}, function (retorno) {
                if (retorno == 2) {
                    validaErro(id, "E-mail incorreto! favor verificar.");
                } else {
                    validaOK(id, "E-mail válido!");
                }
            });
        } else {
            tiraValidacao(id);
        }
    }

    function validaCNPJ(cnpj, id) {
        if (cnpj != "") {
            $.get(urlValida, {valida: 'valcnpj', cnpj: cnpj}, function (retorno) {
                if (retorno == 2) {
                    validaErro(id, "CNPJ inválido! favor verificar.");
                } else {
                    validaOK(id, "CNPJ válido!");
                }
            });
        } else {
            tiraValidacao(id);
        }
    }

    function validaSenha(id, senha) {
        var tamanho = senha.length;
        var forca = 0;
        if ((tamanho >= 4) && (tamanho <= 7)) {
            forca += 10;
        } else if (tamanho > 7) {
            forca += 25;
        }
        if (senha.match(/[a-z]+/)) {
            forca += 10;
        }
        if (senha.match(/[A-Z]+/)) {
            forca += 20;
        }
        if (senha.match(/\d+/)) {
            forca += 20;
        }
        if (senha.match(/\W+/)) {
            forca += 25;
        }

        if (forca < 30) {
            validaErro(id, "Fraca");
        } else if ((forca >= 30) && (forca < 60)) {
            validaOK(id, "Razoável");
        } else if ((forca >= 60) && (forca < 85)) {
            validaOK(id, "Boa");
        } else {
            validaOK(id, "Excelente");
        }

    }

    function confirma_senha(idC, senhaC) {
        var senha = $(".senha").val();
        if (senhaC != senha) {
            validaErro(idC, "Diferente da Senha");
        } else {
            validaOK(idC, "Confirmação OK");
        }
    }

    $(".formulario .ob").change(function () {
        var ob = $(this).val();
        var id = $(this).attr("id");
        var valida = $(this).hasClass("senha");
        var validaC = $(this).hasClass("confirma-senha");

        if (ob != "" && valida) {
            validaSenha(id, ob);
        } else if (ob != "" && validaC) {
            confirma_senha(id, ob);
        } else if (ob != "") {
            validaOK(id, "Campo Obrigatório OK!");
        } else {
            validaErro(id, "Campo Obrigatório");
        }
    });

    function validaErro(id, msg) {
        $('#' + id).parent(".form-group").addClass('has-error').removeClass('has-success');
        $('#' + id).parents('#form-group-' + id).addClass('has-error');
        $('span#' + id + '-info').text(msg).prepend('<i class="fa clip-cancel-circle-2"></i> ');
        if(id == "ds_caminho"){
            var element = $("label[for='" + id + "']").parent(".form-group");
            element.addClass('has-error').removeClass('has-success');
            element.children('.fileupload').children('.thumbnail').addClass('form-control');
        }
        return false;
    }

    function validaOK(id, msg) {
        $('#' + id).parent(".form-group").addClass('has-success').removeClass('has-error');
        $('#' + id).parents('#form-group-' + id).addClass('has-success').removeClass('has-error');
        $('span#' + id + '-info').text(msg).prepend('<i class="fa clip-checkmark-circle-2"></i> ');
        if(id == "ds_caminho"){
            var element = $("label[for='" + id + "']").parent(".form-group");
            element.addClass('has-success').removeClass('has-error');
            element.children('.fileupload').children('.thumbnail').removeClass('form-control');
        }
        return true;
    }

    function tiraValidacao(id) {
        $('#' + id).parent(".form-group").removeClass('has-success').removeClass('has-error');
        $('#' + id).parents('#form-group-' + id).removeClass('has-success').removeClass('has-error');
        $('span#' + id + '-info').text(".");
        if(id == "ds_caminho"){
            var element = $("label[for='" + id + "']").parent(".form-group");
            element.removeClass('has-error has-success');
            element.children('.fileupload').children('.thumbnail').removeClass('form-control');
        }
        return true;
    }

    function mascaraTel(element, valor) {
        if (valor.length === 11) {
            element.unmask();
            element.mask("(99) 99999-999?9");
        } else if (valor.length === 10) {
            element.unmask();
            element.mask("(99) 9999-9999?9");
        }
    }

    // MASCARAS

    // Somente letras maiúsculas, minúsculas, espaço e acentos
    $(".nome").keyup(function () {
        var valor = $(this).val().replace(/[^a-zA-Z à-úÀ-Ú]+/g, '');
        $(this).val(valor);
    });
    $.mask.definitions['h'] = "[0-2]";
    $.mask.definitions['g'] = "[0-9]";
    $.mask.definitions['m'] = "[0-6]";
    $.mask.definitions['s'] = "[0-9]";
    $(".horas").mask("hg:ms").change(function () {
        var horas = $(this).val().substring(0, 2);
        var minutos = $(this).val().substring(3, 5);
        var id = $(this).attr("id");
        if ((horas > 23) || (minutos > 59)) {
            validaErro(id, "Horário Inválido!");
            $(this).val("");
        }
    }).keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        var valor = valor.val().replace(/[^:]+/g, '');
        $(this).val(valor);
    });
    $(".cep").mask("99.999-999").keyup(function () {
        var valor = $(this).val().replace(/[^0-9-.]+/g, '');
        valor = valor.val().replace(/[^-.]+/g, '');
        $(this).val(valor);
    });

    var campo_cep = $('#nu_cep');
    if (campo_cep.length) {
        campo_cep.change(function () {
            var cep = $(this).val().replace('-', '').replace('.', '');
            if (cep.length === 8) {
                $.get("https://viacep.com.br/ws/" + cep + "/json", function (data) {
                    if (!data.erro) {
                        $('#ds_bairro').val(data.bairro);
                        $('#ds_complemento').val(data.complemento);
                        $('#no_cidade').val(data.localidade);
                        $('#ds_endereco').val(data.logradouro);
                        $('#sg_uf').val(data.uf).trigger("change.select2");
                    }
                }, 'json');
            }
        });
    }
    $(".tel").mask("(99) 9999-9999?9").keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        mascaraTel($(this), valor);
        valor = valor.val().replace(/[^()-]+/g, '');
        $(this).val(valor);
    });
    $(".tel0800").mask("0800-999-9999").keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        valor = valor.val().replace(/[^-]+/g, '');
        $(this).val(valor);
    });

    $(".tel").each(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        mascaraTel($(this), valor);
    });

    ///// VERIFICA INTERVALO DE DATAS
    function gerarData(str) {
        var partes = str.split("/");
        return new Date(partes[2], partes[1] - 1, partes[0]);
    }

    function verificarIntervaloDatas(id) {
        var inicio = $(".dt1").val();
        var fim = $(".dt2").val();
        if (fim && inicio) {
            if (gerarData(fim) < gerarData(inicio)) {
                var id1 = $(".dt1").attr('id');
                var id2 = $(".dt2").attr('id');
                $('#' + id1).val('');
                $('#' + id2).val('');
                $('#' + id1).parent(".form-group").removeClass('has-success');
                $('#' + id2).parent(".form-group").removeClass('has-success');
                $('.' + id1).parent(".form-group").removeClass('has-success');
                $('.' + id2).parent(".form-group").removeClass('has-success');
                $('span#' + id1 + '-info').text('');
                $('span#' + id2 + '-info').text('');
                Funcoes.Alerta("A data inicial é maior que a data final");
            }
        }
    }

    $(".dt1, .dt2").change(function () {
        var id = $(this).attr("id");
        verificarIntervaloDatas(id);
    });

    $(".data").mask("99/99/9999").change(function () {
        var data = $(this).val();
        var id = $(this).attr("id");
        validaData(data, id);
    }).datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "c-80:c+15",
            currentText: "Hoje",
            monthNamesShort: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
            dateFormat: "dd/mm/yy",
            showMonthAfterYear: true,
            showAnim: "clip"
        }
    ).keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        valor = valor.val().replace(/[^/]+/g, '');
        $(this).val(valor);
    });
    $(".cpf").mask("999.999.999-99").change(function () {
        var cpf = $(this).val();
        var id = $(this).attr("id");
        validaCPF(cpf, id);
    }).keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        valor = valor.val().replace(/[^.-]+/g, '');
        $(this).val(valor);
    });
    $(".cnpj").mask("99.999.999/9999-99").change(function () {
        var cnpj = $(this).val();
        var id = $(this).attr("id");
        validaCNPJ(cnpj, id);
    }).keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        valor = valor.val().replace(/[^/.-]+/g, '');
        $(this).val(valor);
    });
    $(".email").change(function () {
        var email = $(this).val();
        var id = $(this).attr("id");
        validaEmail(email, id)
    });
    $(".senha").keyup(function () {
        var senha = $(this).val();
        var id = $(this).attr("id");
        validaSenha(id, senha);
    });
    $(".confirma-senha").keyup(function () {
        var senhaC = $(this).val();
        var idC = $(this).attr("id");
        confirma_senha(idC, senhaC);
    });
    $(".numero").keypress(function (e) {
        var tecla = (window.event) ? event.keyCode : e.which;
        if ((tecla > 47 && tecla < 58))
            return true;
        else if (tecla == 8 || tecla == 0) {
            return true;
        }
        else {
            return false;
        }
    }).keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        $(this).val(valor);
    });
    $(".moeda").maskMoney({
        symbol: 'R$ ',
        showSymbol: true,
        thousands: '.',
        decimal: ',',
        symbolStay: true
    }).focusout(function () {
        var valor = $(this).val();
        if (valor == "" || valor == "R$ 0,00") {
            $(this).val("");
        }
    }).keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        if(valor != '000'){
            validaOK(id, "Campo Obrigatório OK!");
        }
        valor = valor.val().replace(/[^,.]+/g, '');
        $(this).val(valor);
    });
    $(".porcentagem").maskMoney({
        symbol: '',
        showSymbol: false,
        thousands: '.',
        decimal: ',',
        reverse: true,
        symbolStay: true
    }).focusout(function () {
        var valor = $(this).val();
        if (valor == "" || valor == "0,00") {
            $(this).val("");
        }
    }).keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        valor = valor.val().replace(/[^,.]+/g, '');
        $(this).val(valor);
    }).attr('maxlength', 5);

    $(".formulario").submit(function () {
        var obrigatorios = campoObrigatorio();
        var validacao = "";
        $(".go-top,.alert .close").click();
        $(".formulario .has-error").each(function () {
            validacao = "error";
        });

        if (obrigatorios == true) {
            if (validacao == "error") {
                Funcoes.Alerta("Existe(em) campo(s) inválido(s), favor verificar!");
                return false;
            }
        } else {
            Funcoes.Informativo("Existe(em) campo(s) obrigatório(s) em branco, favor verificar!");
            return false;
        }
    });

    //CAMPO OBRIGATÓRIO
    function campoObrigatorio() {
        var campos = "";
        $(".formulario .ob").each(function () {
            var valor = $(this).val();
            var id = $(this).attr("id");
            var tem = id.search("s2id_");
            var valida = false;

            if (tem != 0) {
                if (valor == "") {
                    campos = "teste";
                    validaErro(id, "Campo Obrigatório");
                }
            } else {
                $("#" + id + " ul li").each(function () {
                    if ($(this).hasClass("select2-search-choice")) {
                        valida = true;
                    }
                });
                if (!$("#" + id).hasClass("multipla")) {
                    valida = true;
                }
                if (!valida) {
                    validaErro(id, "Campo Obrigatório");
                }
            }

            if (valor != "") {
                if ($(this).hasClass("senha")) {
                    validaSenha(id, valor);
                }
                if ($(this).hasClass("confirma-senha")) {
                    confirma_senha(id, valor);
                }
            }
        });
        if (campos != "") {
            $(".ob:first").focus();
            Funcoes.Alerta('Existem campos em branco que são obrigatórios ou campos inválidos, favor verificar');
            return false;
        } else {
            return true;
        }
    }

    $(".deleta_registro .btn-success").click(function () {
        var id = $(this).attr("id");
        var entidade = $(".deleta_registro").attr("id");
        var msg = $(this).attr("data-msg-restricao");
        $("#load").click();

        $.get(urlValida, {valida: 'deleta_registro', entidade: entidade, id: id}, function (retorno) {
            if (retorno == true) {
                window.setTimeout('location.reload()', 1);
            } else if (retorno != "") {
                if (msg) {
                    $.get(urlValida, {valida: 'msg_valida', msg: msg}, function (retorno) {
                        Funcoes.Alerta("Não foi possível a exclusão do registro.<br><br>" + retorno);
                    });
                } else {
                    Funcoes.Alerta("Não foi possível a exclusão do registro.");
                }
            } else {
                Funcoes.Erro("Foi identificado um Erro<br><br>" +
                    "Favor entrar em contato com o Administrador do Sistema<br>Informando o erro ocorrido.");
            }
            $("#carregando .cancelar").click();
        });
    });

    $(".deleta").click(function () {
        var id = $(this).attr("id");
        var MSG = $(this).attr("data-msg-restricao");
        $(".deleta_registro .btn-success").attr('id', id);
        $(".deleta_registro .btn-success").attr('data-msg-restricao', MSG);
        $("#registro-" + id).attr("style", "").css("background", "#ffcccc").addClass("deletando");
    });

    //Esconde a model de notificação
    setTimeout(function () {
        $(".gritter-aviso").animate({
            right: -500
        }, "slow");
    }, 8000);

    $('.gritter-close').click(function () {
        $(this).parents(".gritter-notice-wrapper").fadeOut('slow');
    });

    // Ler a quantidade de notificações
    $(window).load(function () {
        var itens = 0;
        $(".notifica li").each(function () {
            if($(this).children('li')){
                itens++;
            }
        });
        $("span .nu_notificacoes").text(itens);
        if(itens > 0){
            $("#notif").addClass('pulse');
        }

    });

    $(".cancelar").click(function () {
        $(".deletando").css("background", "#fdfdfd").removeClass("deletando");
    });

    // FECHA MODAL DE CONFIRMAÇÃO
    $(".confirmacao .btn-success").click(function () {
        location.reload();
    });

    // ATIVA E DESATIVA O MENU.
    $(".main-navigation-menu li").click(function () {
        $(".main-navigation-menu").find("li").removeClass("active").removeClass("open");
        $(".main-navigation-menu li ul li").css("display", "none");
        $(this).addClass("active");
        $(this).find("li").css("display", "block");
    });

    // CLASSE QUE DISABILITA O CAMPO
    $(".disabilita").attr("disabled", true);

    // ABRE MODAL DE LOAD DO SISTEMA
    $("#load").click();

    // ABRE MODAL DE CONFIRMAÇÃO DE EMAIL
    $("#emailConfirma").click();

    // FECHA MODAL DE LOAD APOS CARREGAR A PÁGINA
    $(window).load(function () {
        $("#carregando .cancelar").click();
    });

    if ($("#sumir").hasClass('alert')) {
        irAoTopo();
    }

    //Função de subir a página ao topo
    function irAoTopo() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
    }

});