<?php

/**
 * ProjetoForm [ FORM ]
 * @copyright (c) 2018, Leo Bessa
 */
class ProjetoForm
{
    public static function Cadastrar($res = false)
    {
        $id = "cadastroProjeto";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Cadastrar", 6);

        if ($res):
            $formulario->setValor($res);
        endif;

        $formulario
            ->setId(NO_PROJETO)
            ->setLabel("Nome do Projeto")
            ->setClasses("ob")
            ->CriaInpunt();

        Form::CriaInputHidden($formulario, $res, [CO_PROJETO]);

        return $formulario->finalizaForm();
    }


}

?>
   