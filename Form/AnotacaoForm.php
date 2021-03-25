<?php

/**
 * AnotacaoForm [ FORM ]
 * @copyright (c) 2017, Leo Bessa
 */
class AnotacaoForm
{
    public static function Cadastrar($res = false)
    {
        $id = "cadastroAnotacao";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Cadastrar", 6);
        if ($res):
            $formulario->setValor($res);
        endif;

        $formulario
            ->setId('ds_titulo_hist')
            ->setLabel("Anotação da História")
            ->setClasses("disabilita")
            ->CriaInpunt();

        $formulario
            ->setId(DS_TITULO)
            ->setClasses("ob")
            ->setLabel("Título da Anotacao")
            ->CriaInpunt();

        $formulario
            ->setType(TiposCampoEnum::TEXTAREA)
//            ->setClasses("editor")
            ->setId(DS_OBSERVACAO)
            ->setLabel("Descrição da Anotação")
            ->CriaInpunt();

        Form::CriaInputHidden($formulario, $res, [CO_HISTORIA, CO_ANOTACAO]);

        return $formulario->finalizaForm('Anotacao/ListarAnotacao/' .
            Valida::GeraParametro(CO_HISTORIA . "/" . $res[CO_HISTORIA]));
    }
}

?>
   