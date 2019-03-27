<?php

/**
 * Class TipoPagamento
 */
class StatusUsuarioEnum extends AbstractEnum
{
    const ATIVO = 'A';
    const INATIVO = 'I';

    public static $descricao = [
        StatusUsuarioEnum::ATIVO => 'Ativo',
        StatusUsuarioEnum::INATIVO => 'Inativo',
    ];
}
