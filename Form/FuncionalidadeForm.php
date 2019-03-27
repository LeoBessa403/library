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

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Apresentar no Menu?")
            ->setClasses($res[ST_MENU])
            ->setId(ST_MENU)
            ->setType("checkbox")
            ->setTamanhoInput(6)
            ->setOptions($label_options2)
            ->CriaInpunt();

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Nova Controller?")
            ->setClasses($res['nova_controller'])
            ->setId('nova_controller')
            ->setType("checkbox")
            ->setTamanhoInput(6)
            ->setOptions($label_options2)
            ->CriaInpunt();

        $formulario
            ->setId(CO_CONTROLLER)
            ->setAutocomplete(
                ControllerEntidade::TABELA,
                NO_CONTROLLER,
                ControllerEntidade::CHAVE
            )
            ->setType("select")
            ->setLabel("Controller da Action")
            ->setClasses("ob")
            ->CriaInpunt();

        $formulario
            ->setId(NO_CONTROLLER)
            ->setClasses("ob")
            ->setLabel("Nome Nova Controller")
            ->CriaInpunt();

        $formulario
            ->setId(DS_CLASS_ICON)
            ->setClasses("ob")
            ->setLabel("Classe do Ícone")
            ->CriaInpunt();

        $formulario
            ->setId(NO_FUNCIONALIDADE)
            ->setClasses("ob")
            ->setLabel("Funcionalidade")
            ->CriaInpunt();

        $formulario
            ->setId(DS_ACTION)
            ->setClasses("ob")
            ->setLabel("Action da Controller")
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

        if (!empty($res[CO_FUNCIONALIDADE])):
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
   