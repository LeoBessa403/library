<?php

/**
 * Class Configurações padrões do sistema
 */
class ConfiguracoesEnum extends AbstractEnum
{
    const DIAS_EXPERIMENTAR = 15;
    const PROFISSIONAIS_BAIXA = 3;
    const PROFISSIONAIS_MEDIA = 20;
    const PROFISSIONAIS_ALTA = 50;
    const TAXA_PROFISSIONAIS_BAIXA = 2.00;
    const TAXA_PROFISSIONAIS_MEDIA = 1.75;
    const TAXA_PROFISSIONAIS_ALTA = 1.50;
    const DIAS_EXPIRADO = 5;


    public static $descricao = [
        ConfiguracoesEnum::DIAS_EXPERIMENTAR => 'Quinze',
    ];
}