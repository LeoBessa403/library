<?php
/**
 * Created by IntelliJ IDEA.
 * User: alexmedeiros
 * Date: 17/10/2016
 * Time: 13:13
 */


class AuditoriaEnum extends AbstractEnum
{
    const INSERT = 'I';
    const UPDATE = 'U';
    const DELETE = 'D';

    protected static $descricao = [
        AuditoriaEnum::INSERT => 'Inseriu',
        AuditoriaEnum::UPDATE => 'Atualizou',
        AuditoriaEnum::DELETE => 'Deletou',
    ];
}
