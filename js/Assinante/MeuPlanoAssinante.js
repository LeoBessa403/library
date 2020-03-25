$(function () {

    // ABRE MODAL DE DETALHAMENTO DO AGENDAMENTO
    $('.btn-visualizar').click(function () {
        var coPlanoAssAss = $(this).attr('data-coPlanoAssAss');
        var dados = Funcoes.Ajax('Assinante/DetalharPagamentoAjax', coPlanoAssAss);

        $('.st_status b').empty().append(dados.st_status);
        $('.Code b').text(dados.ds_code_transacao);
        $('.plano b').text(dados.no_plano);
        $('.Data_Pagamento b').text(dados.dt_confirma_pagamento);
        $('.Situacao_Pagamento b').text(dados.st_pagamento);
        $('.Meio_Pagamento b').text(dados.tp_pagamento);
        $('.Valor_Ass b').text(dados.nu_valor_assinatura);
        $('.Profissionais b').text(dados.nu_profissionais);
        $('.Valor_Desconto b').text(dados.nu_valor_desconto);
        $('.Valor_Liquido b').text(dados.nu_valor_real);
        $('.transacoes').empty();
        $.each(dados.co_historico_pag_assinatura, function (i, obj) {
            $('.transacoes').append('<p>' + obj + '</p>');
        });
        $("#j_listar").click();
    });
});