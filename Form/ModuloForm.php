<?php

/**
 * ModuloForm [ FORM ]
 * @copyright (c) 2017, Leo Bessa
 */
class ModuloForm
{
    public static function Cadastrar($res = false)
    {
        $id = "cadastroModulo";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Cadastrar", 6);
        if ($res):
            $formulario->setValor($res);
        endif;

        $formulario
            ->setId(NO_PROJETO)
            ->setLabel("Projeto do Modulo")
            ->setClasses("disabilita")
            ->CriaInpunt();

        $formulario
            ->setId(NO_MODULO)
            ->setClasses("ob")
            ->setLabel("Nome do Modulo")
            ->CriaInpunt();

        Form::CriaInputHidden($formulario, $res, [CO_PROJETO, CO_MODULO]);

        return $formulario->finalizaForm('Modulo/ListarModulo/' .
            Valida::GeraParametro(CO_PROJETO . "/" . $res[CO_PROJETO]));
    }
}

?>
   