$(function () {

    var imgBand = '';
    var submit = false;

    $('.debito,.credito').parents('.form-group').hide();

    var dados = Funcoes.Ajax('Assinante/getSessaoPagamentoAssinante', null);
    //ID da sessão retornada pelo PagSeguro
    PagSeguroDirectPayment.setSessionId(dados.id);
    carregaBancos();

    $("#co_plano").change(function () {
        limpaComboParcelas();
        iniciaComboParcelas();
        $(".cartao_credito").val('');
        Funcoes.TiraValidacao('numCartao');
    });

    $("#tp_pagamento").change(function () {
        var tpPagamento = $(this).val();
        if (tpPagamento == 3) {
            $('.debito').parents('.form-group').hide();
            $('.credito').parents('.form-group').show();
        } else if (tpPagamento == 4) {
            $('.debito').parents('.form-group').show();
            $('.credito').parents('.form-group').hide();
        } else {
            $('.debito,.credito').parents('.form-group').hide();
        }
    });

    $(".cartao_credito").keyup(function () {
        var numCartao = $(this).val().replace(/[^0-9]+/g, '');
        var TamNumCartao = numCartao.length;
        var spanBandeira = $(this).parents('.input-group').children('span.input-group-addon');
        var spanMensagem = $(this).parents('.input-group').parents('.form-group').children('span.help-block');

        //Validar o cartão quando o usuário digitar 6 digitos do cartão
        if (TamNumCartao == 6) {
            // spanBandeira.empty();

            //Instanciar a API do PagSeguro para validar o cartão
            PagSeguroDirectPayment.getBrand({
                cardBin: numCartao,
                success: function (retorno) {
                    //Enviar para o index a imagem da bandeira
                    imgBand = retorno.brand.name;
                    spanBandeira.html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/" + imgBand + ".png'>");
                    // $('#bandeiraCartao').val(imgBand);
                },
                error: function (retorno) {
                    //Enviar para o index a mensagem de erro
                    spanBandeira.empty();
                    spanMensagem.text('Cartão inválido').prepend('<i class="fa clip-checkmark-circle-2"></i> ');
                },
                complete: function (retorno) {
                    $(this).focus();
                }
            });
        } else if (TamNumCartao < 6) {
            spanBandeira.empty();
            Funcoes.ValidaErro('numCartao', 'Cartão inválido');

            limpaComboParcelas();
            iniciaComboParcelas();
        }

        var valor = $(this).val().replace(/[^0-9]+/g, '');
        valor = valor.val().replace(/[^.-]+/g, '');
        $(this).val(valor);

    }).focusout(function () {
        var spanBandeira = $(this).parents('.input-group').children('span.input-group-addon');
        var numCartao = $(this).val().replace(/[^0-9]+/g, '');
        var TamNumCartao = numCartao.length;

        if (TamNumCartao < 16) {
            spanBandeira.empty();
            Funcoes.ValidaErro('numCartao', 'Cartão inválido');
            limpaComboParcelas();
            iniciaComboParcelas();
        } else {
            $('#bandeiraCartao').val(imgBand);
            Funcoes.ValidaOK('numCartao', 'Cartão Válido');
            recupParcelas(imgBand);
        }
    });

//Recuperar a quantidade de parcelas e o valor das parcelas no PagSeguro
    function recupParcelas(bandeira) {
        var coPlano = $("#co_plano").val();
        var comboParc = $("#qntParcelas");
        if (coPlano) {
            var dados = Funcoes.Ajax('Assinante/getValorPlano', coPlano);
            var valorPlano = dados.nu_valor_assinatura;
            limpaComboParcelas();

            // NÚMERO DE PARCELAS SEM JUROS
            var noIntInstalQuantity = 3;
            PagSeguroDirectPayment.getInstallments({

                //Valor do produto
                amount: valorPlano,

                //Quantidade de parcelas sem juro
                maxInstallmentNoInterest: noIntInstalQuantity,

                //Tipo da bandeira
                brand: bandeira,
                success: function (retorno) {
                    $.each(retorno.installments, function (ia, obja) {
                        $.each(obja, function (ib, objb) {
                            //Converter o preço para o formato real com JavaScript
                            var valorParcela = objb.installmentAmount.toFixed(2).replace(".", ",");

                            //Apresentar quantidade de parcelas e o valor das parcelas para o usuário no campo SELECT
                            comboParc.append(new Option(objb.quantity + " x R$ " + valorParcela,
                                objb.quantity, false, false)).trigger('change');
                        });
                    });
                    iniciaComboParcelas();
                },
                error: function (retorno) {
                    // callback para chamadas que falharam.
                },
                complete: function (retorno) {
                    // Callback para todas chamadas.
                }
            });
        }
    }

    $("#qntParcelas").change(function () {
        if ($(this).val() != 'null') {
            var valorParcela =  $("#qntParcelas option:selected").text().split(' x R$ ');
            $("#installmentValue").val(valorParcela[1]);
        }
    });

    function limpaComboParcelas() {
        var comboParc = $("#qntParcelas");
        comboParc.select2("destroy");
        comboParc.empty();
        var newOptionParc = new Option('Selecione um Parcelamento', null, false, false);
        comboParc.append(newOptionParc).trigger('change');
    }

    function iniciaComboParcelas() {
        var comboParc = $("#qntParcelas");
        comboParc.select2({
            allowClear: false
        });
    }

    function carregaBancos() {
        PagSeguroDirectPayment.getPaymentMethods({
            amount: '15.00',
            success: function (retorno) {

                console.log(retorno);

                var comboBank = $("#bankName");
                comboBank.select2("destroy");
                comboBank.empty();
                var newOptionBank = new Option('Selecione um Banco', null, false, false);
                comboBank.append(newOptionBank).trigger('change');

                $.each(retorno.paymentMethods.ONLINE_DEBIT.options, function (i, obj) {
                    //Apresentar quantidade de parcelas e o valor das parcelas para o usuário no campo SELECT
                    comboBank.append(new Option(obj.displayName,
                        obj.name, false, false)).trigger('change');
                });

                comboBank.select2({
                    allowClear: false
                });
            },
            error: function (retorno) {
                // Callback para chamadas que falharam.
            },
            complete: function (retorno) {
                // Callback para todas chamadas.
            }
        });
    }

    //Recuperar o token do cartão de crédito
    $("#RenovaPlanoAssinante").on("submit", function (event) {
        if (!submit) {
            event.preventDefault();
            submit = true;
        }

        var tpPagamento = $("#tp_pagamento").val();

        if (tpPagamento == 3) {
            var validade = $('#validadeCartao').val().split('/');
            PagSeguroDirectPayment.createCardToken({
                cardNumber: $('#numCartao').val(), // Número do cartão de crédito
                brand: $('#bandeiraCartao').val(), // Bandeira do cartão
                cvv: $('#cvvCartao').val(), // CVV do cartão
                expirationMonth: validade[0], // Mês da expiração do cartão
                expirationYear: '20' + validade[1], // Ano da expiração do cartão, é necessário os 4 dígitos.
                success: function (retorno) {
                    $('#tokenCartao').val(retorno.card.token);
                    recupHashCartao();
                },
                error: function (retorno) {
                    // Callback para chamadas que falharam.
                },
                complete: function (retorno) {
                    // Callback para chamadas que falharam.
                }
            });
        } else if (tpPagamento == 5) {
            recupHashCartao();
        } else if (tpPagamento == 4) {
            recupHashCartao();
        }

    });

    //Recuperar o hash do cartão
    function recupHashCartao() {
        PagSeguroDirectPayment.onSenderHashReady(function (retorno) {
            if (retorno.status == 'error') {
                Funcoes.Erro(retorno.message);
                return false;
            } else {
                $("#hash").val(retorno.senderHash);
                $("#RenovaPlanoAssinante").submit();
            }
        });
    }

});