<?php

class PerfilForm
{
    public static function Cadastrar($res = false)
    {
        $id = "cadastroPerfil";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Cadastrar", 6);
        if ($res):
            $formulario->setValor($res);
        endif;
        $formulario
            ->setId(NO_PERFIL)
            ->setClasses("ob")
            ->setLabel("Perfil")
            ->CriaInpunt();

        $funcs = FuncionalidadeService::montaComboTodosFuncionalidades();
        $formulario
            ->setId(CO_FUNCIONALIDADE)
            ->setLabel("Funcionalidades")
            ->setClasses("multipla")
            ->setInfo("Funcionalidades que o perfil tem acesso.")
            ->setType(TiposCampoEnum::SELECT)
            ->setOptions($funcs)
            ->CriaInpunt();

        if ($res):
            $formulario
                ->setType(TiposCampoEnum::HIDDEN)
                ->setId(CO_PERFIL)
                ->setValues($res[CO_PERFIL])
                ->CriaInpunt();
        endif;

        return $formulario->finalizaForm();
    }
}

?>
   