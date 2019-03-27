<?php
/**
 * Created by IntelliJ IDEA.
 * User: alexmedeiros
 * Date: 17/10/2016
 * Time: 13:13
 */


class TiposMensagemEnum extends AbstractEnum
{
    const SUCESSO = 1;
    const INFORMATIVO = 2;
    const ALERTA = 3;
    const ERRO = 4;

    public static $descricao = [
        TiposMensagemEnum::SUCESSO => 'Sucesso',
        TiposMensagemEnum::INFORMATIVO => 'Informativo',
        TiposMensagemEnum::ALERTA => 'Alerta',
        TiposMensagemEnum::ERRO => 'Error',
    ];

    public static $classes = [
        TiposMensagemEnum::SUCESSO => 'success',
        TiposMensagemEnum::INFORMATIVO => 'info',
        TiposMensagemEnum::ALERTA => 'warning',
        TiposMensagemEnum::ERRO => 'danger',
    ];
}
