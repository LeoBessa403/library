<?php

/**
 * Class TipoPagamento
 */
class StatusAcessoEnum extends AbstractEnum
{
    const ATIVO = 'A';
    const FINALIZADO = 'F';
    const DESISTENTE = 'D';

    public static $descricao = [
        StatusAcessoEnum::ATIVO => 'Ativo',
        StatusAcessoEnum::FINALIZADO => 'Finalizado',
        StatusAcessoEnum::DESISTENTE => 'Desistente'
    ];
}
