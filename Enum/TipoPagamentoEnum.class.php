<?php

/**
 * Class TipoPagamento
 */
class TipoPagamentoEnum extends AbstractEnum
{
    const DINHEIRO = 1;
    const CARTAO_DEBITO = 2;
    const CARTAO_CREDITO = 3;
    const DEPOSITO_TRANSFERENCIA = 4;
    const BOLETO = 5;
    const PROMISSORIA = 6;
    const CHEQUE = 7;
    const PARCELAMENTO_PROPRIO = 8;
    const OUTROS = 9;

    public static $descricao = [
        TipoPagamentoEnum::DINHEIRO => 'Dinheiro',
        TipoPagamentoEnum::CARTAO_DEBITO => 'Cartão de Débito',
        TipoPagamentoEnum::CARTAO_CREDITO => 'Cartão de Crédito',
        TipoPagamentoEnum::DEPOSITO_TRANSFERENCIA => 'Depósito/Transferência Bancária',
        TipoPagamentoEnum::BOLETO => 'Boleto Bancário',
        TipoPagamentoEnum::PROMISSORIA => 'Promissória',
        TipoPagamentoEnum::CHEQUE => 'Cheque',
        TipoPagamentoEnum::PARCELAMENTO_PROPRIO => 'Parcelamento Próprio',
        TipoPagamentoEnum::OUTROS => 'Outros',
    ];
}
