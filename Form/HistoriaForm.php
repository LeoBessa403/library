<?php

/**
 * HistoriaForm [ FORM ]
 * @copyright (c) 2017, Leo Bessa
 */
class HistoriaForm
{
    public static function Cadastrar($res = false)
    {
        $id = "cadastroHistoria";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Cadastrar", 6);
        if ($res):
            $formulario->setValor($res);
        endif;

        $formulario
            ->setId(NO_SESSAO)
            ->setLabel("Sessão da Historia")
            ->setClasses("disabilita")
            ->CriaInpunt();

        $formulario
            ->setId(DS_TITULO)
            ->setClasses("ob")
            ->setLabel("Título da Historia")
            ->CriaInpunt();

        $formulario
            ->setType(TiposCampoEnum::TEXTAREA)
//            ->setClasses("ckeditor")
            ->setId(DS_OBSERVACAO)
            ->setLabel("Descrição da História")
            ->CriaInpunt();

        $label_options = HistoriaService::comboEsforco();
        $formulario
            ->setLabel("Total do Esforço")
            ->setId(NU_ESFORCO)
            ->setType(TiposCampoEnum::SELECT)
            ->setTamanhoInput(6)
            ->setOptions($label_options)
            ->CriaInpunt();

        $formulario
            ->setId(NU_ESFORCO_RESTANTE)
            ->setClasses("numero ob")
            ->setLabel("Esforço Restante")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        Form::CriaInputHidden($formulario, $res, [CO_SESSAO, CO_HISTORIA]);

        return $formulario->finalizaForm('Historia/ListarHistoria/' .
            Valida::GeraParametro(CO_SESSAO . "/" . $res[CO_SESSAO]));
    }
}

?>
   