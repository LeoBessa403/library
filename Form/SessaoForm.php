<?php

/**
 * SessaoForm [ FORM ]
 * @copyright (c) 2017, Leo Bessa
 */
class SessaoForm
{
    public static function Cadastrar($res = false)
    {
        $id = "cadastroSessao";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Cadastrar", 6);
        if ($res):
            $formulario->setValor($res);
        endif;

        $formulario
            ->setId(NO_MODULO)
            ->setLabel("Modulo da Sessao")
            ->setClasses("disabilita")
            ->CriaInpunt();

        $formulario
            ->setId(NO_SESSAO)
            ->setClasses("ob")
            ->setLabel("Nome da Sessao")
            ->CriaInpunt();

        Form::CriaInputHidden($formulario, $res, [CO_MODULO, CO_SESSAO]);

        return $formulario->finalizaForm('Sessao/ListarSessao/' .
            Valida::GeraParametro(CO_MODULO . "/" . $res[CO_MODULO]));
    }
}

?>
   