<?php

/**
 * Class AssinanteEnum
 */
class AssinanteEnum extends AbstractEnum
{
    const MATRIZ = "M";
    const FILIAL = "F";

    public static $descricao = [
        AssinanteEnum::MATRIZ => 'Matriz',
        AssinanteEnum::FILIAL => 'Filial',
    ];
}
