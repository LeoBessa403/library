<?php
/**
 * Created by IntelliJ IDEA.
 * User: alexmedeiros
 * Date: 17/10/2016
 * Time: 13:13
 */


class SimNaoEnum extends AbstractEnum
{
    const SIM = 'S';
    const NAO = 'N';

    protected static $descricao = [
        SimNaoEnum::SIM => 'Sim',
        SimNaoEnum::NAO => 'Não'
    ];
}
