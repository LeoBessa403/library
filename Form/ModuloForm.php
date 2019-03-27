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

        $formulario
            ->setType("hidden")
            ->setId(CO_PROJETO)
            ->setValues($res[CO_PROJETO])
            ->CriaInpunt();

        if (!empty($res[CO_MODULO])):
            $formulario
                ->setType("hidden")
                ->setId(CO_MODULO)
                ->setValues($res[CO_MODULO])
                ->CriaInpunt();
        endif;

        return $formulario->finalizaForm('Modulo/ListarModulo/' .
            Valida::GeraParametro(CO_PROJETO . "/" . $res[CO_PROJETO]));
    }
}

?>
   