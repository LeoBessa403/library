<?php

class FuncionalidadeForm
{
    public static function Cadastrar($res = false)
    {
        $id = "cadastroFuncionalidade";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Cadastrar", 6);
        if ($res):
            $formulario->setValor($res);
        endif;

        $formulario
            ->setId(NO_FUNCIONALIDADE)
            ->setClasses("ob")
            ->setLabel("Funcionalidade")
            ->CriaInpunt();

        $perfis = PerfilService::montaComboTodosPerfis();
        $formulario
            ->setId(CO_PERFIL)
            ->setLabel("Perfis")
            ->setClasses("multipla")
            ->setInfo("Perfis que podem acessar a funcionalidade.")
            ->setType("select")
            ->setOptions($perfis)
            ->CriaInpunt();


        if ($res):
            $formulario
                ->setType("hidden")
                ->setId(CO_FUNCIONALIDADE)
                ->setValues($res[CO_FUNCIONALIDADE])
                ->CriaInpunt();
        endif;


        return $formulario->finalizaForm();
    }
}
?>
   