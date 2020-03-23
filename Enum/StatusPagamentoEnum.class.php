<?php

/**
 * Class StatusPagamento
 */
class StatusPagamentoEnum extends AbstractEnum
{
    const PENDENTE = 0;
    const AGUARDANDO_PAGAMENTO = 1;
    const EM_ANALISE = 2;
    const PAGO = 3;
    const DISPONIVEL = 4;
    const EM_DISPUTA = 5;
    const DEVOLVIDA = 6;
    const CANCELADA = 7;

    public static $descricao = [
        StatusPagamentoEnum::PENDENTE => 'Pendente',
        StatusPagamentoEnum::AGUARDANDO_PAGAMENTO => 'Aguardando pagamento',
        StatusPagamentoEnum::EM_ANALISE => 'Em análise',
        StatusPagamentoEnum::PAGO => 'Pago ',
        StatusPagamentoEnum::DISPONIVEL => 'Pago e Disponível',
        StatusPagamentoEnum::EM_DISPUTA => 'Em disputa',
        StatusPagamentoEnum::DEVOLVIDA => 'Devolvida',
        StatusPagamentoEnum::CANCELADA => 'Cancelada',
    ];
}
