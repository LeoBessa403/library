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
           $("#model_confirmacao").click();
           return false;
        });

        $('#btn-success-Config').click(function () {
            location.href=$('#config').attr('href');
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
        LimiteImagens: function () {
            Funcoes.Alerta("Quantidade Acima da Permitida! Permitido Somente <b>" + limite + " Foto(s)</b>.")
        },

        MSG_CONFIRMACAO: "CONFIRMAÇÃO"

    };
}();

