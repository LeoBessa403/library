var Funcoes = function () {
    var inicio = function () {

        // CADASTRO De Retiro de Carnaval
        function disabilitaCamposnovaController() {
            if ($("#nova_controller").prop('checked')) {
                $("#co_controller").parent(".form-group").hide();
                $("#no_controller").parent(".form-group").show();
                $("#ds_class_icon").parent(".form-group").show();
                $("#co_controller").removeClass('ob');
            } else {
                $("#co_controller").parent(".form-group").show();
                $("#no_controller").parent(".form-group").hide();
                $("#ds_class_icon").parent(".form-group").hide();
                $("#no_controller").removeClass('ob');
                $("#ds_class_icon").removeClass('ob');
            }
        }

        disabilitaCamposnovaController();

        $("#nova_controller").change(function () {
            disabilitaCamposnovaController();
        });

        // Botão Reset
        $('#config').click(function () {
            $("#model_confirmacao_ativacao").click();
            return false;
        });

        $('#btn-success-Config').click(function () {
            location.href = $('#config').attr('href');
        });
    };
    return {
        init: function () {
            inicio();
        },
        Modal: function (msg, classe, titulo) {
            var element = $(".alerta-js");
            element.removeClass("gritter-success,gritter-warning,gritter-info,gritter-danger").addClass("gritter-" + classe);
            $(".alerta-js span.gritter-title").text(titulo);
            $(".alerta-js span.mensagem-alerta-js").html(msg);
            element.show();
        },
        Sucesso: function (msg) {
            Funcoes.Modal(msg, "success", "SUCESSO");
        },
        Alerta: function (msg) {
            Funcoes.Modal(msg, "warning", "ALERTA");
        },
        Informativo: function (msg) {
            Funcoes.Modal(msg, "info", "INFORMATIVO");
        },
        Erro: function (msg) {
            Funcoes.Modal(msg, "danger", "Erro");
        },
        CadastradoSucesso: function () {
            Funcoes.Modal($("#cadastrado").attr('data-val'), "success", "Cadastrado com Sucesso!");
        },
        AtualizadoSucesso: function () {
            Funcoes.Modal($("#atualizado").attr('data-val'), "info", "Atualizado com Sucesso!");
        },
        DeletadoSucesso: function () {
            Funcoes.Modal($("#deletado").attr('data-val'), "success", "Deletado com Sucesso!");
        },
        LimiteImagens: function (limite) {
            Funcoes.Alerta("Quantidade Acima da Permitida! Permitido Somente <b>" + limite + " Foto(s)</b>.")
        },
        Ajax: function (controller, codigo) {
            //VARIÁVEL GLOBAL
            var home = $("#home").attr('data-val');
            var urlValida = home + 'library/Controller/Ajax.Controller.php?acao=Ajax';
            var retornoAjax = {};
            $.ajax({
                url: urlValida,
                data: {controller: controller, codigo: codigo},
                type: "POST",
                dataType: "json",
                async: false,
                beforeSend: function () {
                    $("#load").click();
                    $('.img-load').fadeIn('slow');
                },
                success: function (data) {
                    retornoAjax = data;
                },
                error: function (e) {
                    retornoAjax = {
                        sucesso: false,
                        msg: 'Erro no Ajax'
                    };
                },
                complete: function () {
                    $("#carregando .cancelar").click();
                    $('.img-load').fadeOut('fast');
                    Funcoes.ValidarCampos();
                }
            });
            return retornoAjax;
        },
        ValidarCampos: function () {
            var campos = "";
            $(".formulario .ob").each(function () {
                var valor = $(this).val();
                var id = $(this).attr("id");
                var tem = id.search("s2id_");
                var valida = false;

                if (tem != 0) {
                    if (valor == "") {
                        campos = "teste";
                        Funcoes.ValidaErro(id, "Campo Obrigatório");
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
                        Funcoes.ValidaErro(id, "Campo Obrigatório");
                    }
                }

                if (valor != "") {
                    if ($(this).hasClass("senha")) {
                        Funcoes.ValidaSenha(id, valor);
                    }
                    if ($(this).hasClass("confirma-senha")) {
                        Funcoes.ConfirmaSenha(id, valor);
                    }
                }
            });
            return campos;
        },
        ValidaErro: function (id, msg) {
            $('#' + id).parent(".form-group").addClass('has-error').removeClass('has-success');
            $('.' + id + '_parent').addClass('has-error').removeClass('has-success');
            $('#' + id).parents('#form-group-' + id).addClass('has-error');
            $('span#' + id + '-info').text(msg).prepend('<i class="fa clip-cancel-circle-2"></i> ');
            if (id == "ds_caminho") {
                var element = $("label[for='" + id + "']").parent(".form-group");
                element.addClass('has-error').removeClass('has-success');
                element.children('.fileupload').children('.thumbnail').addClass('form-control');
            }
            return false;
        },
        ValidaOK: function (id, msg) {
            $('#' + id).parent(".form-group").addClass('has-success').removeClass('has-error');
            $('.' + id + '_parent').addClass('has-success').removeClass('has-error');
            $('#' + id).parents('#form-group-' + id).addClass('has-success').removeClass('has-error');
            $('span#' + id + '-info').text(msg).prepend('<i class="fa clip-checkmark-circle-2"></i> ');
            if (id == "ds_caminho") {
                var element = $("label[for='" + id + "']").parent(".form-group");
                element.addClass('has-success').removeClass('has-error');
                element.children('.fileupload').children('.thumbnail').removeClass('form-control');
            }
            return true;
        },
        TiraValidacao: function (id) {
            $('#' + id).parent(".form-group").removeClass('has-success').removeClass('has-error');
            $('.' + id + '_parent').removeClass('has-success').removeClass('has-error');
            $('#' + id).parents('#form-group-' + id).removeClass('has-success').removeClass('has-error');
            $('span#' + id + '-info').text(".");
            if (id == "ds_caminho") {
                var element = $("label[for='" + id + "']").parent(".form-group");
                element.removeClass('has-error has-success');
                element.children('.fileupload').children('.thumbnail').removeClass('form-control');
            }
            return true;
        },
        ValidaSenha: function (id, senha) {
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
                Funcoes.ValidaErro(id, "Fraca");
            } else if ((forca >= 30) && (forca < 60)) {
                Funcoes.ValidaOK(id, "Razoável");
            } else if ((forca >= 60) && (forca < 85)) {
                Funcoes.ValidaOK(id, "Boa");
            } else {
                Funcoes.ValidaOK(id, "Excelente");
            }

        },
        ConfirmaSenha: function (idC, senhaC) {
            var senha = $(".senha").val();
            if (senhaC != senha) {
                Funcoes.ValidaErro(idC, "Diferente da Senha");
            } else {
                Funcoes.ValidaOK(idC, "Confirmação OK");
            }
        },
        MSG_CONFIRMACAO: "CONFIRMAÇÃO"

    };
}();