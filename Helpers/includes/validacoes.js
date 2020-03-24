$(function () {

    //VARIÁVEIS GLOBAIS
    var home = $("#home").attr('data-val');
    var inativo = parseInt($("#inativo").attr('data-val'));
    var ambiente = $("#ambiente").attr('data-val');
    var urlValida = home + 'library/Helpers/Valida.Controller.php';

    // DESLOGA USUÁRIO INATIVO DO MODULO DO SISTEMA
    if (ambiente === 'admin') {
        setTimeout(function () {
            location.reload();
        }, (1001 * inativo * 60));
    }

    //function to initiate Select2
    $(".search-select").select2({
        allowClear: false
    });

    function validaData(data, id) {
        if (data !== "") {
            var erro = "";
            var bissexto = 0;
            var tam = data.length;
            if (tam === 10) {
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
                            if ((ano % 4 === 0) || (ano % 100 === 0) || (ano % 400 === 0)) {
                                bissexto = 1;
                            }
                            if ((bissexto === 1) && (dia <= 29)) {
                                erro = true;
                            }
                            if ((bissexto !== 1) && (dia <= 28)) {
                                erro = true;
                            }
                            break
                    }
                }
            }
            if (erro !== true) {
                Funcoes.ValidaErro(id, "DATA Informada Inválida!");
            } else {
                Funcoes.ValidaOK(id, "Data válida!");
            }
        } else {
            Funcoes.TiraValidacao(id);
        }
    }

    function validaCPF(cpf, id) {
        if (cpf !== "") {
            $.get(urlValida, {valida: 'valcpf', cpf: cpf}, function (retorno) {
                if (retorno === 2) {
                    Funcoes.ValidaErro(id, "CPF inválido! favor verificar.");
                } else {
                    Funcoes.ValidaOK(id, "CPF válido!");
                }
            });
        } else {
            Funcoes.TiraValidacao(id);
        }
    }

    function validaEmail(email, id) {
        if (email !== "") {
            $.get(urlValida, {valida: 'valemail', email: email}, function (retorno) {
                if (retorno === 2) {
                    Funcoes.ValidaErro(id, "E-mail incorreto! favor verificar.");
                } else {
                    Funcoes.ValidaOK(id, "E-mail válido!");
                }
            });
        } else {
            Funcoes.TiraValidacao(id);
        }
    }

    function validaCNPJ(cnpj, id) {
        if (cnpj !== "") {
            $.get(urlValida, {valida: 'valcnpj', cnpj: cnpj}, function (retorno) {
                if (retorno === 2) {
                    Funcoes.ValidaErro(id, "CNPJ inválido! favor verificar.");
                } else {
                    Funcoes.ValidaOK(id, "CNPJ válido!");
                }
            });
        } else {
            Funcoes.TiraValidacao(id);
        }
    }

    $(".formulario .ob").change(function () {
        var ob = $(this).val();
        var id = $(this).attr("id");
        var valida = $(this).hasClass("senha");
        var validaC = $(this).hasClass("confirma-senha");

        if (ob !== "" && valida) {
            Funcoes.ValidaSenha(id, ob);
        } else if (ob !== "" && validaC) {
            Funcoes.ConfirmaSenha(id, ob);
        } else if (ob !== "") {
            Funcoes.ValidaOK(id, "Campo Obrigatório OK!");
        } else {
            Funcoes.ValidaErro(id, "Campo Obrigatório");
        }
    });

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
            Funcoes.ValidaErro(id, "Horário Inválido!");
            $(this).val("");
        }
    }).keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        valor = valor.val().replace(/[^:]+/g, '');
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

    $(".cartao_credito").mask("9999 9999 9999 9999");

    $(".cvv").mask("999").keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        valor = valor.val().replace(/[^.-]+/g, '');
        $(this).val(valor);
    });

    $(".validade_cartao").mask("99/99").keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        valor = valor.val().replace(/[^.-]+/g, '');
        $(this).val(valor);
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
        Funcoes.ValidaSenha(id, senha);
    });
    $(".confirma-senha").keyup(function () {
        var senhaC = $(this).val();
        var idC = $(this).attr("id");
        Funcoes.ConfirmaSenha(idC, senhaC);
    });
    $(".numero").keypress(function (e) {
        var tecla = (window.event) ? event.keyCode : e.which;
        if ((tecla > 47 && tecla < 58))
            return true;
        else if (tecla === 8 || tecla === 0) {
            return true;
        } else {
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
        if (valor === "" || valor === "R$ 0,00") {
            $(this).val("");
        }
    }).keyup(function () {
        var id = $(this).attr("id");
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        if (valor !== '000') {
            Funcoes.ValidaOK(id, "Campo Obrigatório OK!");
        }
        valor = valor.val().replace(/[^,.]+/g, '');
        $(this).val(valor);
    });
    $(".porc-decimal").maskMoney({
        symbol: '',
        showSymbol: false,
        thousands: '',
        decimal: ',',
        reverse: true,
        symbolStay: true
    }).focusout(function () {
        var valor = $(this).val();
        if (valor === "" || valor === "0,00") {
            $(this).val("");
        }
    }).keyup(function () {
        var valor = $(this).val().replace(/[^0-9]+/g, '');
        valor = valor.val().replace(/[^,.]+/g, '');
        $(this).val(valor);
    }).attr('maxlength', 5);

    $(".porc-int").mask('9?9').attr('maxlength', 2).attr('placeholder', 0);


    $(".formulario").submit(function () {
        var formAjax = $(this).parents('.j_cadastro').attr('id');
        var formPesquisaAjax = $(this).parents('.j_pesquisar').attr('id');
        if (!formAjax && !formPesquisaAjax) {
            $('.img-load').fadeIn('slow');
            var obrigatorios = campoObrigatorio();
            var validacao = "";
            $(".go-top,.alert .close").click();
            $(".formulario .has-error").each(function () {
                validacao = "error";
            });

            if (obrigatorios == true) {
                if (validacao == "error") {
                    Funcoes.Alerta("Existe(em) campo(s) inválido(s), favor verificar!");
                    $('.img-load').fadeOut('fast');
                    return false;
                }
            } else {
                Funcoes.Informativo("Existe(em) campo(s) obrigatório(s) em branco, favor verificar!");
                $('.img-load').fadeOut('fast');
                return false;
            }
        }
    });

    //CAMPO OBRIGATÓRIO
    function campoObrigatorio() {
        var campos = Funcoes.ValidarCampos();
        if (campos !== "") {
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
            if (retorno === true) {
                window.setTimeout('location.reload()', 1);
            } else if (retorno !== "") {
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
            if ($(this).children('li')) {
                itens++;
            }
        });
        $("span .nu_notificacoes").text(itens);
        if (itens > 0) {
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

    ///// START CAMPO SLIDER  /////
    var sliderValoresMin = $(".slider_basico").parents('.sliders').children('.slider_min');
    var sliderValoresMax = $(".slider_basico").parents('.sliders').children('.slider_max');

    $(".slider_basico").rangeSlider({
        defaultValues: {
            min: sliderValoresMin.val(),
            max: sliderValoresMax.val()
        },
        bounds: {
            min: parseInt(sliderValoresMin.attr('data-min')),
            max: parseInt(sliderValoresMax.attr('data-max'))
        },
        valueLabels: "change",
        delayOut: 1000,
        formatter: function (val) {
            var value = Math.round(val * 5) / 5,
                decimal = value - Math.round(val);
            return value - decimal;
        }
    }).bind("valuesChanged", function (e, data) {
        atualizaRangeSlider($(this), data);
    });

    function atualizaRangeSlider(e, data) {
        var min = calculaSlider(data.values.min);
        var max = calculaSlider(data.values.max);
        e.parents('.sliders').children('.slider_min').val(min);
        e.parents('.sliders').children('.slider_max').val(max);
        e.parents('.form-group').children('.control-label').children('span').empty();
        e.parents('.form-group').children('.control-label').append('<span> de <b>' + min + '</b> a <b>' + max + '</b></span>');
    }

    function calculaSlider(valor) {
        var value = Math.round(valor * 5) / 5,
            decimal = value - Math.round(valor);
        return value - decimal;
    }

    ///// END CAMPO SLIDER  /////

});