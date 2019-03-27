<?php

/**
 * Class TipoPagamento
 */
class StatusHistoriaEnum extends AbstractEnum
{
    const NAO_INICIADA = 'N';
    const INICIADA = 'I';
    const CONCLUIDA = 'C';

    public static $descricao = [
        StatusHistoriaEnum::NAO_INICIADA => 'Não Iniciada',
        StatusHistoriaEnum::INICIADA => 'Iniciada',
        StatusHistoriaEnum::CONCLUIDA => 'Concluída',
    ];
}
