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

        if (!empty($res[CO_PROJETO])):
            $formulario
                ->setType("hidden")
                ->setId(CO_PROJETO)
                ->setValues($res[CO_PROJETO])
                ->CriaInpunt();
        endif;

        return $formulario->finalizaForm();
    }

}

?>
   