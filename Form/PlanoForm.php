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
            ->setType(TiposCampoEnum::CHECKBOX)
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
            ->setType(TiposCampoEnum::SELECT)
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
            ->setId(CO_PACOTE)
            ->setAutocomplete(
                PacoteEntidade::TABELA,
                NO_PACOTE,
                PacoteEntidade::CHAVE
            )
            ->setType(TiposCampoEnum::SELECT)
            ->setLabel("Pacotes do plano")
            ->setClasses("ob multipla")
            ->CriaInpunt();

        $formulario
            ->setType(TiposCampoEnum::TEXTAREA)
            ->setId(DS_OBSERVACAO)
            ->setLabel("Observação")
            ->CriaInpunt();


        if (!empty($res[CO_PLANO])):
            $formulario
                ->setType(TiposCampoEnum::HIDDEN)
                ->setId(CO_PLANO)
                ->setValues($res[CO_PLANO])
                ->CriaInpunt();
        endif;

        return $formulario->finalizaForm();
    }


}
