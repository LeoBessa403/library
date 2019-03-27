<?php

/**
 * Class TipoPagamento
 */
class StatusSistemaEnum extends AbstractEnum
{
    const ATIVO = 'A';
    const EXPIRANDO = 'E';
    const PENDENTE = 'P';
    const BLOQUEADO = 'B';
    const EXPIRADO = 'R';

    public static $descricao = [
        StatusSistemaEnum::ATIVO => 'Ativo',
        StatusSistemaEnum::EXPIRANDO => 'Expirando',
        StatusSistemaEnum::PENDENTE => 'Pendente',
        StatusSistemaEnum::BLOQUEADO => 'Bloqueado',
        StatusSistemaEnum::EXPIRADO => 'Expirado'
    ];
}
