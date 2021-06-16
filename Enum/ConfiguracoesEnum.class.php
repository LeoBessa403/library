<?php

/**
 * Class Configurações padrões do sistema
 */
class ConfiguracoesEnum extends AbstractEnum
{
    const DIAS_EXPERIMENTAR = 15;
    const DIAS_EXPIRADO = 5;
    const DIAS_EXPIRANDO = 7;


    public static $descricao = [
        ConfiguracoesEnum::DIAS_EXPERIMENTAR => 'Quinze',
    ];
}