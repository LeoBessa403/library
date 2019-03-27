<?php

class AuditoriaForm
{

    public static function Pesquisar()
    {
        $id = "pesquisaAcesso";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Pesquisa", 12);

        $usuarios = UsuarioService::PesquisaUsuariosCombo([]);
        $formulario
            ->setId(CO_USUARIO)
            ->setLabel("Nome do Usuário")
            ->setClasses("multipla")
            ->setInfo("Pode selecionar vários USUÁRIOS.")
            ->setType("select")
            ->setOptions($usuarios)
            ->CriaInpunt();

        $tabelas = AuditoriaService::PesquisaTabelasCombo();
        $formulario
            ->setId(NO_TABELA)
            ->setLabel("Entidade")
            ->setClasses("multipla")
            ->setInfo("Pode selecionar várias TABELAS.")
            ->setType("select")
            ->setOptions($tabelas)
            ->CriaInpunt();

        $formulario
            ->setId(CO_REGISTRO)
            ->setTamanhoInput(4)
            ->setClasses("numero")
            ->setLabel("Código do Registro")
            ->CriaInpunt();

        $formulario
            ->setId('dt1')
            ->setIcon("clip-calendar-3")
            ->setTamanhoInput(4)
            ->setClasses("data dt1 ob")
            ->setValor(date('d/m/Y'))
            ->setLabel("Período Inicío")
            ->CriaInpunt();

        $formulario
            ->setId('dt2')
            ->setIcon("clip-calendar-3")
            ->setTamanhoInput(4)
            ->setValor(date('d/m/Y'))
            ->setClasses("data dt2 ob")
            ->setLabel("Fim")
            ->CriaInpunt();

        return $formulario->finalizaFormPesquisaAvancada();
    }
}
?>
   