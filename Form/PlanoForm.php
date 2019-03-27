<?php

/**
 * ProdutoForm [ FORM ]
 * @copyright (c) 2018, Leo Bessa
 */
class PlanoForm
{
    public static function Cadastrar($res = false)
    {
        $id = "cadastroPlano";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Cadastrar", 6);
        $formulario->setValor($res);

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Plano Ativo")
            ->setClasses($res[ST_STATUS])
            ->setId(ST_STATUS)
            ->setType("checkbox")
            ->setTamanhoInput(12)
            ->setOptions($label_options2)
            ->CriaInpunt();

        $formulario
            ->setId(NO_PLANO)
            ->setLabel("Plano")
            ->setClasses("ob")
            ->CriaInpunt();

        $label_options = PlanoService::montaComboMesesAtivos();
        $formulario
            ->setLabel("Meses Ativo")
            ->setId(NU_MES_ATIVO)
            ->setType("select")
            ->setClasses("ob")
            ->setTamanhoInput(8)
            ->setOptions($label_options)
            ->setInfo("Número de meses que o plano ficarar ativo")
            ->CriaInpunt();


        $formulario
            ->setId(NU_VALOR)
            ->setClasses("moeda ob")
            ->setLabel("Valor R$")
            ->setTamanhoInput(4)
            ->CriaInpunt();

        $formulario
            ->setId(CO_MODULO)
            ->setAutocomplete(
                ModuloEntidade::TABELA,
                NO_MODULO,
                ModuloEntidade::CHAVE
            )
            ->setType("select")
            ->setLabel("Módulos do plano")
            ->setClasses("ob multipla")
            ->CriaInpunt();

        $formulario
            ->setType("textarea")
            ->setId(DS_OBSERVACAO)
            ->setLabel("Observação")
            ->CriaInpunt();


        if (!empty($res[CO_PLANO])):
            $formulario
                ->setType("hidden")
                ->setId(CO_PLANO)
                ->setValues($res[CO_PLANO])
                ->CriaInpunt();
        endif;

        return $formulario->finalizaForm();
    }


}
